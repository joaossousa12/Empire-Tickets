<?php
    require_once(__DIR__ . '/../database/connection.db.php');


    $id = $_POST['id'];
    $department = $_POST['department'];

    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE TICKET SET DEPARTMENT = ? WHERE TICKETID = ?');
    $stmt->execute(array( $department,$id));

    echo 'Item updated successfully';
?>