<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/ticket.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');


    class Hashtag{
        public string $name;

        public function __construct(string $name){
            $this->name = $name;
        }

        static function getHashtagsByTicketId(PDO $db, int $ticketId){
            $stmt = $db->prepare('SELECT HASHTAG.HASHTAG
                                        FROM TICKET_HASHTAG
                                        JOIN HASHTAG ON TICKET_HASHTAG.HASHTAGID = HASHTAG.HASHTAGID
                                        WHERE TICKET_HASHTAG.TICKETID = ?');
            $stmt->execute(array($ticketId));
            $hashtags = array();
            while ($hash = $stmt->fetch()) {
                $hashtags[] = new Hashtag(
                    $hash['HASHTAG']
                );
            }
            
            return $hashtags;
        }

        static function getTicketsByHashTag(PDO $db, string $hashtag){
            $stmt = $db->prepare(   'SELECT TICKETID, TITLE, DEPARTMENT, CLIENT, PRIORITY, STATUS, DESCRIPTION, TICKETDATE 
                                    FROM TICKET
                                    JOIN TICKET_HASHTAG ON TICKET.TICKETID = TICKET_HASHTAG.TICKETID
                                    JOIN HASHTAG ON TICKET_HASHTAG.HASHTAGID = HASHTAG.HASHTAGID
                                    WHERE HASHTAG.HASHTAG = ?');

            $tickets = array($hashtag);
            while($ticket = $stmt->fetch()){
                $tickets[] = new Ticket(
                    $ticket['TICKETID'], 
                    $ticket['TITLE'],
                    $ticket['DEPARTMENT'],
                    $ticket['CLIENT'],
                    $ticket['PRIORITY'],
                    $ticket['STATUS'],
                    $ticket['DESCRIPTION'],
                    $ticket['TICKETDATE']
                );
            }
            
            return $tickets;
        }


        static function getAllLike(PDO $db, string $name): array{
            
            $stmt = $db->prepare('SELECT HASHTAG FROM HASHTAG WHERE HASHTAG LIKE ?');
            $stmt->execute(array($name));
            $results = array();
            while($result = $stmt->fetch()){
                $results[] = $result['HASHTAG'];
            }
            error_log('result:'.print_r($results,true));
            return $results;
        }


        static function getHashtagId(PDO $db, string $hashtag) {
            $stmt = $db->prepare("
                SELECT HASHTAGID
                FROM HASHTAG
                WHERE HASHTAG = ?
            ");
            $stmt->execute(array($hashtag));
    
            $result = $stmt->fetch();
            return $result['HASHTAGID'];
        }
    
        static function insertHashtag(PDO $db, string $hashtag) {
            $stmt = $db->prepare("
                INSERT INTO HASHTAG (HASHTAG) VALUES ( ? )");
            $stmt->execute(array($hashtag));
        }


        static function addHashtagToTicket(PDO $db, int $ticketId, string $hashtag) {
            $hashtagId = Hashtag::getHashtagId($db, $hashtag);
            error_log('id:'.print_r($hashtagId,true));
    
            $stmt = $db->prepare("
                INSERT INTO TICKET_HASHTAG (TICKETID, HASHTAGID)
                VALUES ( ? , ? )
            ");
            $stmt->execute(array($ticketId, $hashtagId));
        }

        static function createHashtag(PDO $db, string $hashtag) : ?Hashtag {
            $stmt = $db->prepare('SELECT * FROM HASHTAG WHERE HASHTAG = ?');

            $stmt->execute(array($hashtag));

            if($stmt->fetch()) return null;

            $stmt = $db->prepare('INSERT INTO HASHTAG(HASHTAG) VALUES (?)');

            $stmt->execute(array($hashtag));

            return new Hashtag($hashtag);
        }
  
    }
?>