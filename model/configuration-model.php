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