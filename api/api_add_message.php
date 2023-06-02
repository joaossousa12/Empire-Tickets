<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    
    $content = $_POST['content'];
    $author = $_POST['author'];
    $ticket = $_POST['ticket'];

    $db = getDatabaseConnection();
    $stmt = $db->prepare('INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES ( ?, ?, ?)');
    $stmt->execute(array($author, $content, $ticket));

?>