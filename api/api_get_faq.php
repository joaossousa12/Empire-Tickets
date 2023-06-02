<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/faq.class.php');
    $db = getDatabaseConnection();
    $id = (int)$_GET['id'];


    $result = Faq::getContentById($db, $id);
    echo 'This problem is solved in our faqs: ' .$result;
         
?>