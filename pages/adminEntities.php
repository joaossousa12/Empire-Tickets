<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) die(header('Location: /'));

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/message.class.php');  

    require_once(__DIR__ . '/../templates/user.tpl.php');

    require_once(__DIR__ . '/../templates/ticket.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    $db = getDatabaseConnection();

    $user = User::getUser($db, $session->getId());

    if(!User::isAdmin($db,$user->id)) die(header('Location: main_agent.php'));

    drawMainPage($session, $user); 
    drawSwitchToAdminView();
    drawAddEntities();
    drawFooter();
?>