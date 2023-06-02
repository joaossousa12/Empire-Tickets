<?php
    require_once(__DIR__ . '/../database/connection.db.php');


    $id = $_POST['id'];
    $agent = $_POST['agent'];

    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE TICKET SET AGENT = ? WHERE TICKETID = ?');
    $stmt->execute(array( $agent,$id));

    echo 'Item updated successfully';
?>