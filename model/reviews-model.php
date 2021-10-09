<?php
// reviews model

function getUserReviews($clientId)
{
    $db = acmeConnect();
    $sql = 'SELECT c.* FROM comments c WHERE c.userId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $prodInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}

/**
 * get config data options and current page status
 */
function getPageStatus($slug)
{
    $db = acmeConnect();
    $sql = 'SELECT (SELECT c.data FROM configuration  c WHERE c.name = "manualPages") as "manualPages",
    (SELECT c.data FROM configuration  c WHERE c.name = "unlimitedReplies") as "unlimitedReplies",
    (SELECT p.id FROM pages p WHERE p.slug = :slug) as id,
    (SELECT p.deleted_at FROM pages p WHERE p.slug = :slug) as deleted_at,
    (SELECT p.lockedcomments FROM pages p WHERE p.slug = :slug) as lockedcomments';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}

function buildTree(array $elements, $userId, $parentId = 0)
{

    $branch = array();

    foreach ($elements as $element) {
        // clean up userids that dont match
        if($element['userId'] != $userId){
            unset($element['userId']);
        }
        if ($element['parentId'] == $parentId) {
            $children = buildTree($elements, $userId, $element['id']);

            if ($children) {
                $element['children'] = $children;
            }

            $branch[] = $element;
        }
    }

    return $branch;
}


/**
 * grab a pages reviews, maybe also grab unapproved one that user owns
 */
function getPageComments($slug, $moderatedComments, $userId)
{
    // TODO: see a logged in users unapproved comments, maybe separate call
    // see the logged in users deleted comments
    $db = acmeConnect();
    $sql = 'SELECT c.id, c.commentText, c.parentId, u.displayName, c.created_at, c.updated_at, c.reviewed_at, c.userId FROM comments c join pages p on c.pageId = p.id join users u on u.id = c.userId WHERE p.slug = :slug and p.deleted_at  is null and c.deleted_at is null';
    if ($moderatedComments) {
        $sql .= ' and c.approved = 1';
    }

    $sql .= ' order by c.created_at asc';

    // echo $sql;
    // exit;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();
    $prodInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    $tree_1 = buildTree($prodInfo, $userId);

    return $tree_1;
}

function getComment($reviewId)
{
    $db = acmeConnect();
    $sql = 'SELECT c.* FROM comments c WHERE c.id = :reviewId';
    // echo $sql;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_STR);
    $stmt->execute();
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}

/**
 * create a comment and return new uuid
 */
function createComment($userId, $pageId, $parentId, $body)
{
    $db = acmeConnect();
    $id = generateUuid();
    $sql = "
    INSERT INTO comments(id, commentText, userId,pageId, parentId)
    VALUES(:id, :body,:userId, :pageId, :parentId);";
    // echo $sql . ":::";
    // echo "userId:".$userId;
    // echo "pageId:".$pageId;
    // echo "parentId:".$parentId;
    // echo "body:".$body;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_STR);
    $stmt->bindValue(':body', $body, PDO::PARAM_STR);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_STR);
    $stmt->bindValue(':pageId', $pageId, PDO::PARAM_STR);
    $stmt->bindValue(':parentId', $parentId, PDO::PARAM_STR);
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();

    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    $result = array('rowsChanged' => $rowsChanged, 'lastId' => $id);
    return $result;
}

function getUnapprovedReviews()
{
    $db = acmeConnect();
    $sql = 'SELECT c.*, p.slug FROM comments as c join pages as p on c.pageId = p.id  WHERE c.approved is null or c.approved != 1;';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $prodInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}


function getReview($reviewId)
{
    $db = acmeConnect();
    $sql = 'SELECT c.id, c.commentText, c.parentId, u.displayName, c.created_at, c.updated_at, c.reviewed_at FROM comments c join pages p on c.pageId = p.id join users u on u.id = c.userId WHERE p.deleted_at  is null and c.deleted_at is null AND c.id = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_STR);
    $stmt->execute();
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}

function deleteReview($reviewId)
{
    $db = acmeConnect();
    $sql = 'DELETE FROM `comments` WHERE id = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

/**
 * update body of a comment
 */
function updateUserComment($id, $body)
{
    $db = acmeConnect();
    // The SQL statement to be used with the database
    // reset approved if it's been updated
    $sql = '
    UPDATE `comments` SET `commentText`=:reviewText, `approved`=0 WHERE id = :reviewId';
    // echo $sql;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $id, PDO::PARAM_STR);
    $stmt->bindValue(':reviewText', $body, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}


/**
 * set delete_at to date value
 */
function deleteUserComment($id)
{
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = '
    UPDATE `comments` SET `deleted_at`=NOW() WHERE id = :reviewId';
    // echo $sql;
    // exit();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $id, PDO::PARAM_STR);
    // $stmt->bindParam(':deleted_at', NOW(), PDO::PARAM_STR);

    // $stmt->bindValue(':reviewText', $body, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
/**
 * change a comment approved number, id, approved, reviewed at changed
 */
function moderateComment($input)
{
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = '
    UPDATE `comments` SET  `reviewed_at`=NOW(), `approved`=:approved WHERE id=:id';

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':id', $input['id'], PDO::PARAM_STR);
    $stmt->bindValue(':approved', $input['approved'], PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
/**
 * Update a review
 */
function updateReview(
    $reviewId,
    $reviewText,
    $reviewDate,
    $invId,
    $clientId
) {
    // Create a connection
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = '
    UPDATE `reviews` SET `reviewText`=:reviewText,`reviewDate`=:reviewDate,`invId`=:invId,`clientId`=:clientId WHERE reviewId = :reviewId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewDate', $reviewDate, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

/**
 * add a review to a product by client id
 */
function addReview($reviewText, $reviewDate, $invId, $clientId)
{
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'INSERT INTO `reviews` (`reviewText`, `reviewDate`, `invId`, `clientId`) VALUES (:reviewText, :reviewDate, :invId, :clientId)';

    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewDate', $reviewDate, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);

    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}
