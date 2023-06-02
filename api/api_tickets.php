<?php
    require_once(__DIR__ . '/../database/connection.db.php');


    $id = $_POST['id'];
    $description = $_POST['description'];

    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE TICKET SET DESCRIPTION = ? WHERE TICKETID = ?');
    $stmt->execute(array( $description,$id));

    echo 'Item updated successfully';
?>