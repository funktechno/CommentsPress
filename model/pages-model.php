<?php


function getPages()
{
    $db = acmeConnect();
    // echo 'test33';
    $sql = 'SELECT * FROM pages';
    // echo $sql;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $prodInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}
/**
 * used when adding comments to auto create a page
 */
function createPage($slug)
{
    $db = acmeConnect();
    $sql = 'INSERT INTO pages(slug,lockedComments)
    VALUES(:slug,0)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}
/**
 * add a new page as admin
 */
function addPage($slug, $lockedComments)
{
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'INSERT INTO pages(slug,lockedComments)
    VALUES(:slug,:lockedComments);';

    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
    $stmt->bindValue(':lockedComments', $lockedComments, PDO::PARAM_INT);

    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

function updatePage($input)
{
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = '
    UPDATE `pages` SET `slug`=:slug, `lockedComments`=:lockedComments WHERE id = :id';

    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':id', $input['id'], PDO::PARAM_STR);
    $stmt->bindValue(':slug', $input['slug'], PDO::PARAM_STR);
    $stmt->bindValue(':lockedComments', $input['lockedComments'], PDO::PARAM_INT);

    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}
