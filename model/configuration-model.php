<?php
// configurations model
function getContactFormEmails()
{
    $db = acmeConnect();
    // echo 'test33';
    $sql = 'SELECT * FROM configuration WHERE name = "contactFormEmails"';
    // echo $sql;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
    // return 'play'
}

function updateConfig($input)
{
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = '
    UPDATE `configuration` SET `data`=:data, `name`=:name WHERE id = :id';
    // echo $sql;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $input['id'], PDO::PARAM_STR);
    $stmt->bindValue(':data', $input['data'], PDO::PARAM_STR);
    $stmt->bindValue(':name', $input['name'], PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function addConfig($input)
{
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'INSERT INTO configuration(name, data)
    VALUES(:name,:data)';

    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':data', $input['data'], PDO::PARAM_STR);
    $stmt->bindValue(':name', $input['name'], PDO::PARAM_STR);

    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

function getConfig()
{
    $db = acmeConnect();
    // echo 'test33';
    $sql = 'SELECT * FROM configuration';
    // echo $sql;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $prodInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}
