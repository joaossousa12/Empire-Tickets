<?php
    require_once(__DIR__ . '/../database/hashtag.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    
    
    $db = getDatabaseConnection();
    
    if (isset($_GET['id']))  {
        $ticketId = (int)$_GET['id'];
        $hashtags = Hashtag::getHashtagsByTicketId($db, $ticketId);

        foreach($hashtags as $hashtag) { 

            echo '<p id ="' .$hashtag->name. '"> #' .$hashtag->name. '</p>';
          }
          echo ' <button class ="roundButton" onclick = "openHashtagSearch('.$ticketId.');"> &#43;</button>';
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo 'Ticket ID is missing or invalid';
    }
    ?>
