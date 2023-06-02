<?php
    require_once(__DIR__ . '/../database/connection.db.php');


    $id = $_POST['id'];
    $status = $_POST['status'];

    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE TICKET SET STATUS = ? WHERE TICKETID= ?');
    $stmt->execute(array( $status,$id));

    echo 'Item updated successfully';
?>