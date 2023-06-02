<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/hashtag.class.php');

    $ticket = $_POST['ticket'];
    $hashtag = $_POST['hashtag'];
    

    $db = getDatabaseConnection();
    Hashtag::addHashtagToTicket($db, $ticket, $hashtag);
    echo 'Item updated successfully';
?>