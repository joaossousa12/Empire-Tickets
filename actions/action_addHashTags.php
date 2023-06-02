<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /'));

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/hashtag.class.php');

  $db = getDatabaseConnection();

  $user = User::getUser($db, $session->getId());

  if(!User::isAdmin($db,$user->id)) die(header('Location: ../pages/main_admin.php'));
  
  $hashtag = Hashtag::createHashtag($db, $_POST['hashtag']);

  if($hashtag){
    $session->addMessage('success', 'Hashtag successfully created!');
    header('Location: ../pages/main_admin.php');
  } else{
    $session->addMessage('error', 'Hashtag already exists!');
    header('Location: ../pages/adminEntities.php');
  }
?>