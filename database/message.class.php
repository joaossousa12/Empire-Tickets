<?php
    declare(strict_types = 1);

    class Message{
        public int $id;
        public int $author;
        public string $content;
        public int $ticket;

        public function __construct(int $id, int $author, string $content, int $ticket){
            $this->id = $id;
            $this->author = $author;
            $this->content = $content;
            $this->ticket = $ticket;
        }

        static function getMessages(PDO $db, int $id) : array {
            $stmt = $db->prepare('SELECT MESSAGEID, AUTHOR, CONTENT, TICKET FROM MESSAGE WHERE TICKET = ? ');
            $stmt->execute(array($id));

            $messages = array();
            while($message= $stmt->fetch()){
                $messages[] = new Message(
                    $message['MESSAGEID'], 
                    $message['AUTHOR'],
                    $message['CONTENT'],
                    $message['TICKET']
                );
            }
            
            return $messages;
        }
  
    }
?>