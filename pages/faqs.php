<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) die(header('Location: /'));

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/faq.class.php');
    require_once(__DIR__ . '/../database/user.class.php');  


    require_once(__DIR__ . '/../templates/common.tpl.php');

    $db = getDatabaseConnection();

    $faqs = Faq::getFaqs($db);

    $user = User::getUser($db, Session::getId());

    $isagent = User::isAgent($db, $user->id);

    drawHead();
    drawFaqs($faqs, $isagent);
    drawFooter();

?>