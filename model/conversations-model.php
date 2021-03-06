<?php
// conversations model

function getConversation($conversationId)
{
    $db = acmeConnect();
    $sql = 'SELECT c.* FROM conversations c WHERE c.threadId = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $conversationId, PDO::PARAM_STR);
    $stmt->execute();
    $prodInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}

function getMessage($id)
{
    $db = acmeConnect();
    $sql = 'SELECT c.* FROM conversations c where c.id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}

function startThread(){
    $id = generateUuid();
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'INSERT INTO threads(id)
    values(:id);';
    // echo $sql;
    $stmt = $db->prepare($sql);

    // $stmt->bindValue(':id', $id, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_STR);

    // // Create the prepared statement using the acme connection

    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    $result = array('rowsChanged' => $rowsChanged, 'lastId' => $id);
    return $result;
}
function sendMessage($conversationId, $message)
{
    // $id = generateUuid();
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'INSERT INTO `conversations`(`threadId`, `message`)
        VALUES (:parentId, :message)';
    // echo $sql;
    $stmt = $db->prepare($sql);

    // $stmt->bindValue(':id', $id, PDO::PARAM_STR);
    $stmt->bindValue(':parentId', $conversationId, PDO::PARAM_STR);
    $stmt->bindValue(':message', $message, PDO::PARAM_STR);


    // // Create the prepared statement using the acme connection

    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    $id = $db->lastinsertid();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    $result = array('rowsChanged' => $rowsChanged, 'lastId' => $id);
    return $result;
}
