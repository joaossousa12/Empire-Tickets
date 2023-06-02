<?php
    declare(strict_types = 1);

    class TicketStatus{
        public int $id;
        public int $user;
        public int $ticket;
        public string $status;

        public function __construct(int $id, int $user, int $ticket, string $status){
            $this->id = $id;
            $this->user = $user;
            $this->ticket = $ticket;
            $this->status = $status;

        }

        static function getStatusByTicket(PDO $db, int $ticket){
            $stmt = $db->prepare('SELECT TICKETSTATUSID, USER, TICKET, STATUS FROM TICKETSTATUS WHERE TICKET = ?');
            $stmt->execute(array($ticket));

            $statuses = array();
            while($status = $stmt->fetch()){
                $statuses[] = new TicketStatus(
                    $status['TICKETSTATUSID'],
                    $status['USER'], 
                    $status['TICKET'],
                    $status['STATUS']
                );
            }
            
            return $statuses;
        }

        static function insertStatus(PDO $db, int $ticket, int $user, string $status){
            $stmt = $db->prepare('INSERT INTO TICKETSTATUS(USER, TICKET, STATUS) VALUES (?, ?, ?)');
            $stmt->execute(array($user, $ticket, $status));
        }

        
    }
        
?>