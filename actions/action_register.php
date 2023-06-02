<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../utils/validate.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    $session = new Session();


    $db = getDatabaseConnection();

    if (!(valid_email($_POST['email'])  &&  valid_name($_POST['username']) && valid_password1($_POST['password']) && valid_CSRF($_SESSION['csrf']))){
        die(header('Location: ../pages/index.php'));
    }

    $user = User::createUser($db, $_POST['name'], $_POST['email'], $_POST['password'], $_POST['username']);

    if($user){
        $session->setId($user->id);
        $session->setName($user->name());
        $session->addMessage('success', 'Registered successfully!');
        header('Location: ../pages/index.php');
        exit();
    } else{
        $session->addMessage('error', 'You already have an account!');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
?>