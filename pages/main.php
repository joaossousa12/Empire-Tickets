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
  drawMainPage($session, $user);


  if(User::isAgent($db, $user->id) || User::isAdmin($db, $user->id)){
    $department = User::getDepartment($db, $user->id);
    $filtered_tickets = Ticket::getFilteredTickets($db, $department, 'all', 'Unassigned');
    $tickets = Ticket::getTickets($db, $user->id);
  }else{
    $tickets = Ticket::getTicketsClient($db, $user->id);
  }

  if(User::isAdmin($db, $user->id)){
    drawSwitchToAdminView();
  }

  if(User::isAgent($db, $user->id) || User::isAdmin($db, $user->id)){
    drawTickets($user->name, $tickets);
    drawFiltered($filtered_tickets);
  } else {
    $tickets = Ticket::getTicketsClient($db, $user->id);
    $departments = Department::getAllDepartments($db);
    drawAddTicket($db);
    drawTicketsClient($user->name, $tickets);
  }
  drawFooter();
?>