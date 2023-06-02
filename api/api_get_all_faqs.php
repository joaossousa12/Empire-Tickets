<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/faq.class.php');

    
    $db = getDatabaseConnection();
    
    $faqs = Faq::getFaqs($db);
    
        foreach($faqs as $faq) { 
            echo '<li class ="faqAnswer" type="button" value = ' . $faq->id .' onclick = "writeFaqMessage('.$faq->id.')">' . $faq->title . '</li>';
          }
         
?>
    