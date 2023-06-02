<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/ticketstatus.class.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $ticket = $_POST['ticket'];
    $user = User::getUser($db, $session->getId());
    $status = $_POST['status'];

    TicketStatus::insertStatus($db, $ticket, $user->id, $status);

?>