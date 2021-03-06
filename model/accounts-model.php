<?php

// accounts model for site visitors


// Get client data based on an email address
function getClient($clientEmail)
{
    $db = acmeConnect();
    $sql = 'SELECT id, displayName, email, clientLevel, password FROM users WHERE email = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
}


/**
 * get images related to a product
 */
function getClientReviews($clientId)
{
    $db = acmeConnect();
    $sql = '
    SELECT `reviewId`, `reviewText`, `reviewDate`, inventory.invName as `invName`, `clientId` FROM `reviews` JOIN inventory ON reviews.invId = inventory.invId WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    $stmt->execute();
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $imageArray;
}

/**
 * check if the email is the same one as the current client id
 */
function checkUpdateExistingEmail($clientId, $clientEmail)
{
    $db = acmeConnect();
    $sql = 'SELECT email FROM users WHERE email = :email and id = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    $stmt->execute();
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();
    if (empty($matchEmail)) {
        return 0;
    } else {
        return 1;
    }
}

//new function will handle site registrations
// Check for an existing email address
function checkExistingEmail($clientEmail)
{
    $db = acmeConnect();
    $sql = 'SELECT email FROM users WHERE email = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();
    if (empty($matchEmail)) {
        return 0;
    } else {
        return 1;
    }
}


function regClient($clientEmail, $clientDisplayName, $hashedPassword)
{
    // Create a connection object using the acme connection function
    // echo 'test2';
    // exit();
    $db = acmeConnect();
    // echo 'test';
    // exit();
    // The SQL statement
    $sql = 'INSERT INTO users (email, displayName, password)
        VALUES (:clientEmail, :clientDisplayName, :clientPassword)';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':clientDisplayName', $clientDisplayName, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $hashedPassword, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

/**
 * update client info
 */
function updateClient(
    $clientDisplayName,
    $clientId
) {
    // Create a connection
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = 'UPDATE users SET displayName = :clientDisplayName WHERE id = :clientId';
    $stmt = $db->prepare($sql);
    // echo $sql;

    $stmt->bindValue(':clientDisplayName', $clientDisplayName, PDO::PARAM_STR);
    // $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    // echo $stmt -> queryString;
    // $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

/**
 * update client password
 */
function updatePassword(
    $clientPassword,
    $clientId
) {
    // Create a connection
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = 'UPDATE users SET password = :clientPassword WHERE id = :clientId';
    $stmt = $db->prepare($sql);

    // $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    // $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    // $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);

    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
