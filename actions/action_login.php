<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../utils/validate.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

 
    $session = new Session();


    $db = getDatabaseConnection();

    if (!(valid_email($_POST['email']) && valid_CSRF($_SESSION['csrf']))){
        die(header('Location: ../pages/index.php'));
    }

    $user = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);

    if ($user) {
        $session->setId($user->id);
        $session->setName($user->name());
        $session->addMessage('success', 'Login successful!');
        if(User::isAdmin($db, $user->id)){
            header('Location: ../pages/main_admin.php');
        } else{
            header('Location: ../pages/main.php');
        }
    } else {
        $session->addMessage('error', 'Wrong password or e-mail!');
        header('Location: ../pages/index.php');
    }
?>