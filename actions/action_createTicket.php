<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../utils/validate.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/ticket.class.php');
    $session = new Session();

    $db = getDatabaseConnection();

    if (!(valid_name($_POST['title']) && valid_text($_POST['department']) && valid_text($_POST['description']) && valid_CSRF($_SESSION['csrf']))) {
        die(header('Location: ../pages/main.php'));
    }

    Ticket::createTicket($db, $_POST['title'], $_POST['department'], $session->getId(), $_POST['description']);
    header('Location: ../pages/main.php');
?>