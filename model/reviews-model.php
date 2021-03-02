<?php
// reviews model

function getUserReviews($clientId){
    $db = acmeConnect();
    $sql = 'SELECT c.* FROM comments c WHERE c.userId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $prodInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}

function getUnapprovedReviews(){
    $db = acmeConnect();
    $sql = 'SELECT c.* FROM comments as c  WHERE c.approved is null or c.approved != 1;';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $prodInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}

function getReview($reviewId)
{
    $db = acmeConnect();
    $sql = 'SELECT reviews.*, inventory.invName as `invName` FROM reviews JOIN inventory ON reviews.invId = inventory.invId WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}

function deleteReview($reviewId)
{
    $db = acmeConnect();
    $sql = 'DELETE FROM `reviews` WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
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
