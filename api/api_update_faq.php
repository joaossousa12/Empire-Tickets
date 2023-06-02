<?php 
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/faq.class.php');


    $db = getDatabaseConnection();

    $id = $_POST['id'];
    $content = $_POST['content'];

    Faq::editFaq($db, $id, $content);

?>