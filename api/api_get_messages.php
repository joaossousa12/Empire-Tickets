<?php
    require_once(__DIR__ . '/../database/message.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    
    $db = getDatabaseConnection();
    
    if (isset($_GET['ticket_id']))  {
        $ticketId = (int)$_GET['ticket_id'];
        $messages = Message::getMessages($db, $ticketId);
        $user = User::getUser($db, $session->getId());
    
        foreach($messages as $message) { 
            echo '<li class = "messages" > <p>' . User::getName($db, $message->author) . ' </p>
            <article type="message">' . 
              $message->content . 
            '</article> </li> ';
          }

          echo ' </ul>';
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo 'Ticket ID is missing or invalid';
    }

?>