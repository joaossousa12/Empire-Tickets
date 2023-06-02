<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../utils/validate.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');
  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /'));


  if (!(valid_name($_POST['Uname']) && valid_email($_POST['Email']) && valid_password($_POST['Password1']) && valid_password($_POST['Password2']) && valid_CSRF($_SESSION['csrf']))){
    die(header('Location: ../pages/profile.php'));
  }

  $db = getDatabaseConnection();

  $user = User::getUser($db, $session->getId());

  if ($user) {
    $user->name = $_POST['Uname'];
    $user->email = $_POST['Email'];
    if($_POST['Password1'] == $_POST['Password2']){
      $user->password = password_hash($_POST['Password1'], PASSWORD_DEFAULT);
    } else{
      $session->addMessage('error', 'Passwords don\'t match!');
      header('Location: ../pages/profile.php');
    }
    
    $user->save($db);

    $session->setName($user->name());
  }

  header('Location: ../pages/profile.php');
?>