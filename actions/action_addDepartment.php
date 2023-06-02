<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /'));

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/dptmt.class.php');

  $db = getDatabaseConnection();

  $user = User::getUser($db, $session->getId());

  if(!User::isAdmin($db,$user->id)) die(header('Location: ../pages/main_admin.php'));
  
  $department = Department::createDepartment($db, $_POST['department']);

  if($department){
    $session->addMessage('success', 'Department successfully created!');
    header('Location: ../pages/main_admin.php');
  } else{
    $session->addMessage('error', 'Department already exists!');
    header('Location: ../pages/adminEntities.php');
  }
?>