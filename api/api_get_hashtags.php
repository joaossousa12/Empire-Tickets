<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/hashtag.class.php');

    
        
    $db = getDatabaseConnection();
    
    $name = $_GET['name'].'%';
    $results = Hashtag::getAllLike($db, $name);

    header('Content-Type: application/json');
    echo json_encode($results);
?>