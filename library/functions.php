<?php
require_once 'error_responses.php';
require_once 'jwt/ValidatesJWT.php';
require_once 'jwt/JWTException.php';
require_once 'jwt/JWT.php';
require_once 'mailFunctions.php';

use Ahc\Jwt\JWT;

/**
 * get the html navigation
 */
function getNavList($categories, $directoryURI)
{
    $list = '<ul>';
    $list .= "<li><a class='" . (strpos($directoryURI, 'home') || !strpos($directoryURI, 'action') ? 'active' : '') . "' href='/acme/index.php' title='View the Acme home page'>Home</a></li>";
    foreach ($categories as $category) {
        $list .= "<li><a class='" . (strpos($directoryURI, $category['categoryName']) ? 'active' : '') . "' href='/acme/products/index.php?action=category&categoryName=" . urlencode($category['categoryName']) . "' title='View our $category[categoryName] product line'>$category[categoryName]</a></li>";
    }
    $list .= '</ul>';
    return $list;
}

function generateUuid()
{
    $db = acmeConnect();
    $sql = "SELECT replace(uuid(),'-','') as 'id';";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo['id'];
}

/**
 * Checks if a folder exist and return canonicalized absolute pathname (sort version)
 * @param string $folder the path being checked.
 * @return mixed returns the canonicalized absolute pathname on success otherwise FALSE is returned
 */
function folder_exist($folder)
{
    // Get canonicalized absolute pathname
    $path = realpath($folder);

    // If it exist, check if it's a directory
    return ($path !== false AND is_dir($path)) ? $path : false;
}

/** 
 * Get header Authorization
 * */
function getAuthorizationHeader()
{
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        //print_r($requestHeaders);
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}
/**
 * get access token from header
 * */
function getBearerToken()
{
    $headers = getAuthorizationHeader();
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

/**
 * 
 */
function IsLoggedInAndHasAccess($clientLevel = null)
{
    if (!isset($_SESSION['loggedin'])) {
        $message = "<p class='notice'>Must be loggedin.</p>";
        $_SESSION['message'] = $message;
        return false;
    }
    if (isset($_SESSION['clientData']) && isset($_SESSION['clientData']['id'])) {

        // check client level
        if (
            $clientLevel != null &&
            $_SESSION['clientData']['clientLevel'] < $clientLevel
        ) {
            $message = "<p class='notice'>User does not have access to this page.</p>";
            $_SESSION['message'] = $message;
            return false;
        }
    } else {
        return false;
    }

    return true;
}

function getJwtToken($clientData)
{
    $jwt = new JWT(SECRET);
    $token = $jwt->encode($clientData);
    return $token;
}

function getJwtPayload($token = null)
{
    if ($token == null)
        $token = getBearerToken();
    $jwt = new JWT(SECRET);
    try {
        $payload = $jwt->decode($token);
    } catch (\Throwable $th) {
        $errorStatus = App\errorStatus::getInstance();
        $errorStatus->response(403, 'Invalid jwt token, likely expired');
    }
    return $payload;
}

/**
 * display products list in html
 */
function buildProductsDisplay($products)
{
    $pd = '<ul id="prod-display">';
    foreach ($products as $product) {
        $pd .= '<li>';
        $pd .= "<img src='$product[invThumbnail]' alt='Image of $product[invName] on Acme.com'>";
        $pd .= '<hr>';
        $pd .= "<h2>$product[invName]</h2>";
        $pd .= "<span>$product[invPrice]</span>";
        $pd .= '</li>';
    }
    $pd .= '</ul>';
    return $pd;
}

function checkEmail($clientEmail)
{
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

// Check the password for a minimum of 8 characters,
// at least one 1 capital letter, at least 1 number and
// at least 1 special character
function checkPassword($clientPassword)
{
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
    return preg_match($pattern, $clientPassword);
}

/**
 * price must support a decimal with no more than 2 decimals
 */
function validatePrice($productPrice)
{
    if ($productPrice < 0)
        return null;
    $pattern = '/^\d+(\d{2})?/';
    return preg_match($pattern, $productPrice);
}

/**
 *  Compare the password just submitted against
 * the hashed password for the matching client
 */
// function password_verify($clientPassword, $hashedPw)
// {
//     $clientPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
//     if ($clientPassword != $hashedPw) {
//         return 0;
//     } else {
//         return 1;
//     }
// }

function sentTestEmail($formEmails)
{
    $result = sendEmail('test email', $formEmails['data'], 'test email successful');


    return $result;
}
/* * ********************************
*  Functions for working with images
* ********************************* */

/**
 *  Adds "-tn" designation to file name
 */
function makeThumbnailName($image)
{
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}


/**
 * Build images display for image management view
 */
function buildImageDisplay($imageArray)
{
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
        $id .= '<li>';
        $id .= "<img src='$image[imgPath]' title='$image[invName] image on Acme.com' alt='$image[invName] image on Acme.com'>";
        $id .= "<p><a href='/acme/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
        $id .= '</li>';
    }
    $id .= '</ul>';
    return $id;
}


/**
 * Build the products select list
 */
function buildProductsSelect($products)
{
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Product</option>";
    foreach ($products as $product) {
        $prodList .= "<option value='$product[invId]'>$product[invName]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
}

/**
 * Handles the file upload process and returns the path
 *  The file path is stored into the database
 */
function uploadFile($name)
{
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
        // Gets the actual file name
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }
        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];
        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;
        // Moves the file to the target folder
        move_uploaded_file($source, $target);
        // Send file for further processing
        processImage($image_dir_path, $filename);
        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;
        // Returns the path where the file is stored
        return $filepath;
    }
}


/**
 * Processes images by getting paths and 
 * creating smaller versions of the image
 */
function processImage($dir, $filename)
{
    // Set up the variables
    $dir = $dir . '/';

    // Set up the image path
    $image_path = $dir . $filename;

    // Set up the thumbnail image path
    $image_path_tn = $dir . makeThumbnailName($filename);

    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);

    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
}


/**
 * Checks and Resizes image
 */
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height)
{

    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];

    // Set up the function names
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
            break;
        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
            break;
        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
            break;
        default:
            return;
    } // ends the resizeImage function

    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);

    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;

    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {

        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);

        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);

        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }

        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }

        // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);
        // Free any memory associated with the new image
        imagedestroy($new_image);
    } else {
        // Write the old image to a new file
        $image_to_file($old_image, $new_image_path);
    }
    // Free any memory associated with the old image
    imagedestroy($old_image);
} // ends the if - else began on line 36
