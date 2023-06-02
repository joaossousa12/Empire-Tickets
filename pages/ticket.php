<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/message.class.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/ticket.tpl.php');

  $db = getDatabaseConnection();

  $ticket = Ticket::getTicket($db, intval($_GET['id']));
  $messages = Message::getMessages($db, $ticket->id);
  $user = User::getUser($db, $session->getId());


  drawHeadTickets();
  drawHomeButton();
  drawTicketDetails($db, $ticket, $user->id);
  drawMessages($messages, $ticket, $db, $user->id);
  drawFooter();
?>