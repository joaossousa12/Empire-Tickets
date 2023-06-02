<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/dptmt.class.php');
  require_once(__DIR__ . '/../database/hashtag.class.php');
  require_once(__DIR__ . '/../database/ticketstatus.class.php');

?>

<?php function drawAddEntity(){ ?>
    <a id="entity" href="adminEntities.php">Add new entity</a>
  </div>
<?php }?>

<?php function drawHeadTickets(){ ?>
    <!DOCTYPE html>
    <html lang="en-US">
    <head>
        <title>Empire Tickets</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/ticket.css">
        <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="../javascript/script.js" defer></script>
    </head>
    <?php  } ?>

<?php function drawTickets(string $user, array $tickets) { ?>
  <div class = "tickets">
  <section id="tickets">
  <h3>Tickets Assigned to you</h3>
    <?php foreach($tickets as $ticket) {  ?>
      <article class="agent">
        <a href="../pages/ticket.php?id=<?=$ticket->id?>"><?=$ticket->title?></a>
        <p id="status"> <?=$ticket->status ?> </p>
        <p id = "priority"> <?= $ticket->priority?> </p>
      </article>
    <?php } ?>
  </section>
<?php } ?>

<?php function drawAddEntities() { ?>
  <h3> Add new entities: </h3>
  <form action="../actions/action_addDepartment.php" method="post" class ="department">

    <label for="department"> Department: </label> 
    <input id="department" type="text" name="department" class="department">

    <label for="submitDepartment"></label>
    <button id="submitDepartment" type="submit" class ="department">Submit</button>
  </form>

  <form action="../actions/action_addStatus.php" method="post" class ="status">

    <label for="status"> Status: </label> 
    <input id="status" type="text" name="status" class="status">

    <label for="submitStatus"></label>
    <button id="submitStatus" type="submit" class ="status">Submit</button>
  </form>
  
  <form action="../actions/action_addHashTags.php" method="post" class ="hashtag">

    <label for="hashtag"> Hashtag: </label> 
    <input id="hashtag" type="text" name="hashtag" class="hashtag">

    <label for="submitHashtag"></label>
    <button id="submitHashtag" type="submit" class ="hashtag">Submit</button>
  </form>
<?php } ?>

<?php function drawAllTickets(array $tickets) { ?>
  <div class = "tickets">
  <section id="tickets">
  <h3>Tickets</h3>
    <?php foreach($tickets as $ticket) {  ?>
      <article class="agent">
        <a href="../pages/ticket.php?id=<?=$ticket->id?>"><?=$ticket->title?></a>
        <p class = "status"> <?=$ticket->status ?> </p>
        <p class = "prio"> <?= $ticket->priority?> </p>
      </article>
    <?php } ?>
  </section>
<?php } ?>

<?php function drawTicketsClient(string $user, array $tickets) { ?>
  <section id="tickets">
    <h3>Your Tickets: </h3>
    <?php foreach($tickets as $ticket) {  ?>
      <article class="client">
        <a href="../pages/ticket.php?id=<?=$ticket->id?>"><?=$ticket->title?></a>
        <p class="ticketDescription">Desc: <?=$ticket->description?></p>
        <p class="status">Status: <?=$ticket->status ?> </p>
        <p class= "prio">Priority: <?=$ticket->priority?></p>
      </article>
    <?php } ?>
  </section>
<?php } ?>


<?php function drawMessages(array $messages, Ticket $ticket, PDO $db, int $user) { ?>
    <section id = "messageBox">
    <ul id= messages>
    <?php foreach($messages as $message) {  ?>
      <li class = "message">
      <p> <?=User::getName($db, $message->author)?> </p>
      <article class = "message">
        <?=$message->content?>
        </article>
    </li>
    <?php } ?>
    </ul>
    <form class="message">
      <span id="content"  class="textarea" role="textbox" contenteditable></span>
      <button type="button" onclick = 'newMessage(<?=$user?>, <?= $ticket->id?>);'>Send</button>

    <?php if (User::isAgent($db, $user)){ ?>
        <input type="button" id = "faqMessage" value = "Answer With Faq" onclick = 'answerWithFaq();'>
      <?php } ?>
      </form>
    </section>
    </div>
<?php } ?>

<?php function drawAddTicket(PDO $db){ ?>
    <input type="button" value="New Ticket" id = "newTicket" class="ticketAdd" onclick = 'openTicket();'>
    <form action="../actions/action_createTicket.php" method="post" id = "ticketForm" class="ticketAdd hide">
      <h3> Create a new Ticket</h3>
        <input type="text" name="title" placeholder="title">
        <select title="department" name="department" id="department" >
        <option value="default" disabled selected>  -Select a department-</option>
            <?php
            $deps = Department::getDepartments($db);
            foreach ($deps as $department) {
                echo '<option value="' . $department->id . '">' . $department->id . '</option>';
            }
            ?>
        </select>
        <input type="text" name="description" placeholder="description">
        <button type="submit">Create</button>
    </form>
    <?php } ?>


<?php function drawFiltered(array $filter_results) { ?>
  <section class="unassigned">
  <h3>Unassigned Tickets</h3>
    <?php foreach($filter_results as $ticket) {  ?>
      <article class = "agent">
        <a href="../pages/ticket.php?id=<?=$ticket->id?>"><?=$ticket->title?></a>
        <p class= "description"><?=$ticket->description?></p>
        <p class = "status"> <?=$ticket->status ?> </p>
        <p class = "prio"><?=$ticket->priority?></p>
      </article>
    <?php } ?>
  </section>
  </div>
<?php } ?>

<?php function drawTicketDetails(PDO $db, Ticket $ticket, int $user){ ?>
  <div class= "ticket">
  <section id="details">
  <h2><?=$ticket->title ?></h2>
  <input type="button"  class = "mobile" value = "Description" onclick = 'descriptionExtend();'>
  <div id = "mobile" class = "mobile">
  <p id="edit"><?= $ticket->description?></p>
  <input id="editDesc" type="button" value='Edit' onclick='addRemoveAttr(<?=$ticket->id?>);'>
  <p>Date: </p>
  <?php if(User::isAgent($db, $user) || User::isAdmin($db, $user)){ ?>
    <label for="priority"> Priority: </label>
    <select id="priority" name="priority" onchange = "updatePriority(<?=$ticket->id ?>);">
      <option value="High" <?php if ($ticket->priority == 'High') { echo ' selected'; } ?>>High</option>
      <option value="Medium" <?php if ($ticket->priority == 'Medium') { echo ' selected'; } ?>>Medium</option>
      <option value="Low" <?php if ($ticket->priority == 'Low') { echo ' selected'; } ?>>Low</option>
    </select>
  <?php } else {?>
    <p>Priority: <?= $ticket->priority?></p>
    <?php }?>
  <?php if(User::isAgent($db, $user) || User::isAdmin($db, $user)){ 
    drawDepartmentOption($db, $ticket);
    } else {?>
    <p>Department: <?= $ticket->department?></p>
  <?php }?>
  <p>Client: <?= User::getName($db, $ticket->client)?></p>
  <?php if((User::isAgent($db, $user) || User::isAdmin($db, $user)) && $ticket->status == 'Unassigned'){ 
    drawAssignForm($db, $ticket);
  } ?>

  <?php if ($ticket->status == 'Assigned'){
    drawCompletedCheck($ticket);
  }?>

  <?php $hashtags = Hashtag::getHashtagsByTicketId($db, $ticket->id);
  echo '<article id = "hashtags">';
    
foreach($hashtags as $hashtag){ 
        echo '<p id=' .$hashtag->name. '> #' .$hashtag->name. '</p>' ;
    }
  
  echo ' <button class ="roundButton" onclick = "openHashtagSearch('.$ticket->id.');"> &#43;</button>
  </article>';    
  ?>
  <a href='../pages/ticket_tracking.php?id=<?=$ticket->id?>' id = "report_link"> Status Report</a>
  </div>
</section>
<?php }?>


<?php function drawDepartmentOption( $db, $ticket){ ?>
    <label for="department"> Department: </label>
    <select id="department" name="department" onchange = "updateDepartment(<?=$ticket->id ?>);">
    <?php $deps = Department::getDepartments($db);
    foreach($deps as $department){ ?>
      <option value=  <?php echo ($department->id); if ($ticket->department == $department->id) { echo ' selected'; } ?>> <?=$department->id ?> </option>
 <?php } ?>
 </select>
<?php }?>

<?php function drawAssignForm($db, $ticket){ ?>
  <p class ="status">This ticket is unassinged. </p>
  <section id="status" class="status">

  
  <label for="assignTicket"> Assign to: </label>
    <select id="assignTicket" name="assignTicket" onchange = "assignTicketTo(<?=$ticket->id ?>);" >
    <option disable selected value > -Select Agent-</option>
  <?php $users = User::getAgentsFromDptmt($db, $ticket->department);
    foreach($users as $user){ ?>
      <option value= <?= $user->id?> > <?= $user->name ?></option>
    <?php } ?>
    </select>
  
</section> 
<div id="reference"></div>
<?php } ?>

<?php function drawCompletedCheck($ticket){ ?>
  <section id="status">
  <label for="completed"> Click to Mark as Completed:</label>
  <input type="checkbox" id="completed" onclick= "setStatus('Completed', <?= $ticket->id?>)"/>
</section>

<?php }?>


<?php function drawTicketStatusTracking($db, $ticket){ 
  $status_ticket = TicketStatus::getStatusByTicket($db, $ticket);?>
  <h2><?=Ticket::getTitle($db, $ticket) ?> - Report</h2>
  <ul id ="status_report">
  <?php foreach($status_ticket as $status){ ?>
    <li> <?=User::getName($db, $status->user)?> : <?= $status->status?></li>
  <?php } ?>
  </ul>
<?php }?>