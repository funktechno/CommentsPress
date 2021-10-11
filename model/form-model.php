<?php

function submitForm($subject, $body, $email)
{
    $db = acmeConnect();
    $sql = 'INSERT INTO contactForms(email,subject,message)
    VALUES(:email,:subject,:body)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
    $stmt->bindValue(':body', $body, PDO::PARAM_STR);
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}


function getContactForms()
{
    $db = acmeConnect();
    $sql = 'SELECT f.* FROM contactForms as f;';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $prodInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}