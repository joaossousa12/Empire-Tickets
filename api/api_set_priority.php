<?php
    require_once(__DIR__ . '/../database/connection.db.php');


    $id = $_POST['id'];
    $priority = $_POST['priority'];

    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE TICKET SET PRIORITY = ? WHERE TICKETID = ?');
    $stmt->execute(array( $priority,$id));

    echo 'Item updated successfully';
?>