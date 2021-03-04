<?php
// configurations model
function getContactFormEmails(){
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

function updateConfig($input){
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = '
    UPDATE `configuration` SET `data`=:data, `name`=:name WHERE id = :id';
    // echo $sql;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $input['id'] , PDO::PARAM_STR);
    $stmt->bindValue(':data', $input['data'], PDO::PARAM_STR);
    $stmt->bindValue(':name', $input['name'], PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function getConfig(){
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