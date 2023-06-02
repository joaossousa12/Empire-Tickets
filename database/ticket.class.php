<?php
    declare(strict_types = 1);

    class Ticket{
        public int $id;
        public string $title;
        public string $department;
        public string $description;
        public int $client;
        public int $agent;
        public string $status;
        public string $priority;
        public string $ticketDate;


        public function __construct(int $id, string $title, string $department, int $client, string $priority, string $status, string $description, string $ticketDate){
            $this->id = $id;
            $this->title = $title;
            $this->department = $department;
            $this->client = $client;
            $this->priority = $priority;
            $this->status = $status;
            $this->description = $description;
            $this->ticketDate = $ticketDate;
        }

        static function getTickets(PDO $db, int $id) : array {
            $stmt = $db->prepare('SELECT TICKETID, TITLE, DEPARTMENT, CLIENT, PRIORITY, STATUS, DESCRIPTION, TICKETDATE FROM TICKET WHERE AGENT = ?');
            $stmt->execute(array($id));

            $tickets = array();
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

        static function getTicketsClient(PDO $db, int $id) : array{
          $stmt = $db->prepare('SELECT TICKETID, TITLE, DEPARTMENT, CLIENT, PRIORITY, STATUS, DESCRIPTION, TICKETDATE FROM TICKET WHERE CLIENT = ?');
          $stmt->execute(array($id));

          $tickets = array();
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

        static function getTicketsAdmin(PDO $db) : array {
          $stmt = $db->prepare('SELECT TICKETID, TITLE, DEPARTMENT, CLIENT, PRIORITY, STATUS, DESCRIPTION, TICKETDATE FROM TICKET');
          $stmt->execute();

          $tickets = array();
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
        static function getTicket(PDO $db, int $id) : Ticket {
            $stmt = $db->prepare('SELECT TICKETID, TITLE, DEPARTMENT, CLIENT, PRIORITY, STATUS, DESCRIPTION, TICKETDATE FROM TICKET WHERE TICKETID = ?');
            $stmt->execute(array($id));
        
            $ticket = $stmt->fetch();
        
            return new Ticket(
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

          static function getTitle(PDO $db, int $id) : string{
            $stmt = $db->prepare('SELECT TITLE FROM TICKET WHERE TICKET.TICKETID == ? LIMIT 1' );
            $stmt->execute(array($id));
  
            $title = $stmt->fetch();
  
            return $title['TITLE'];
          }

          static function createTicket(PDO $db, string $title, string $department, int $clientID, string $description){
            $stmt = $db->prepare('SELECT TITLE, CLIENT FROM TICKET WHERE lower(TITLE) = ? AND CLIENT = ?');


            $status = 'Unassigned';
            $priority = 'Low';
            $dateTime = date('Y-m-d H:i:s');

            $stmt = $db->prepare('INSERT INTO TICKET( TICKETDATE, TITLE, DEPARTMENT, DESCRIPTION, PRIORITY, CLIENT, STATUS)
             VALUES (?, ?, ?, ?, ?, ?, ?)');

             $stmt->execute(array($dateTime, $title, $department, $description, $priority, $clientID, $status));


          }

          static function getFilteredTickets(PDO $db, string $department, string $priority,string $status) : array{
            $filter = array();
            
            if($department != 'all'){
              $filter[] = " DEPARTMENT = '$department' " ;
            }
            
            if($priority != 'all'){
              $filter[] = " PRIORITY =  '$priority' " ;
            }
            if($status != 'all'){
              $filter[] =  " STATUS =  '$status' ";
            }
            

            $result = implode(' AND ', $filter);
            
            $stmt = $db->prepare('SELECT TICKETID, TITLE, DEPARTMENT, CLIENT, PRIORITY, STATUS, DESCRIPTION, TICKETDATE FROM TICKET WHERE' . $result);
            $stmt->execute();


            $tickets = array();
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

        static function createStatus(PDO $db, string $status) : ?String{
          $stmt = $db->prepare('SELECT * FROM STATUS WHERE STATUSID = ?');
          
          $stmt->execute(array($status));
          
          if($stmt->fetch()) return null;

          $stmt = $db->prepare('INSERT INTO STATUS(STATUSID) VALUES (?)');

          $stmt->execute(array($status));

          return $status;
        }
          
    }
?>