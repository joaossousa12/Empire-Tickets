<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawHomeButton() { ?>
  <a href="../pages/main.php"><img src= "../docs/home.png" width = 30 height = 30 id="home" alt="home"></a>
<?php } ?>

<?php function drawHead() {?>
  <!DOCTYPE html>
  <html lang="en-US">
    <head>
      <title> Empire Tickets </title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../css/style.css">
      <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="../javascript/script.js" defer></script>
    </head>
<?php } ?>


<?php function drawMainPage(Session $session, $user){ ?>
    <!DOCTYPE html>
    <html lang="en-US">
    <head>
        <title>Empire Tickets</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/main.css">
        <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="../javascript/script.js" defer></script>
    </head>
    <body class ="mainpage">
      <header>
    <?php 
      drawHeaderMain($user->name);
      drawProfileLink($user);
      drawFaqsLink();
      drawSessionMessages($session);
    ?>
    
    </header>
    <?php  } ?>

    <?php function drawMainPageAdmin(Session $session, $user){ ?>
    <!DOCTYPE html>
    <html lang="en-US">
    <head>
        <title>Empire Tickets</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/main_agent.css">
        <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="../javascript/script.js" defer></script>
    </head>
    <body class ="mainpage">
      <header>
    <?php 
      drawProfileLink($user);
      drawFaqsLink();
      
    ?>
    <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>
      <?php } ?>
    </section>
    </header>
    <?php  } ?>

<?php function drawLoginLogout(Session $session) { ?>
  <body class="login">

    <header>
      <img src="../docs/logo.png" alt = "logo">
      <h1>Empire Tickets</h1>
      <p> We brought peace and stability to the galaxy</p>
      </header>
      <?php 
        if ($session->isLoggedIn()) drawLogoutForm($session);
        else drawLoginForm();
      ?>
<?php } ?> 

<?php function drawSessionMessages(Session $session) { ?>
    <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>
      <?php } ?>
    </section>

<?php } ?>

<?php function drawFooter() { ?>
    <footer>
      <p>Empire Tickets &copy; 2023</p>
      <a href="../pages/index.php" class ="fa" >&#xf011;</a>

    </footer>
  </body>
</html>
<?php } ?>


<?php function drawLoginForm() { ?>
  <form action="../actions/action_login.php" method="post" class="login">

    <input type="email" name="email" placeholder="email" required>
    <input type="password" name="password" placeholder="password" required>
    <button type="submit">Login</button>
    <a href="../pages/register.php">Register</a>
  </form>
<?php } ?>

<?php function drawLogoutForm(Session $session) { ?>
  <form action="../actions/action_logout.php" method="post" class="logout">
    <button type="submit">Logout</button>
    <a href="../pages/profile.php"><?=$session->getName()?></a>
  </form>
<?php } ?>

<?php function drawRegister(Session $session) { ?>
  <body class="register">

    <header>
      <img src="../docs/logo.png" alt="logo">
      <h1><a>Empire Tickets</a></h1>
      <p> We brought peace and stability to the galaxy</p>
      <?php 
        drawRegisterForm();
      ?>
    </header>
  


<?php } ?>

<?php function drawRegisterForm() { ?>
  <form action="../actions/action_register.php" method="post" class="register">

    <input type="text" name="name" placeholder="name" required>
    <input type="text" name="username" placeholder="username" required>
    <input type="email" name="email" placeholder="email" required>
    <input type="password" name="password" placeholder="password" required>
    <button type="submit">Register</button>
    <a href="../pages/index.php">Already have an account? Log-In</a>
  </form>
<?php } ?>

<?php function drawFaqsLink(){  ?>
  <a href="../pages/faqs.php" id = "faqs_link"> FAQ's</a>
<?php }?>

<?php
    function drawFaqs(array $faqs, bool $agent){ ?>
        <header class= "faqs">
            <h2 id = "faqs">Frequently Asked Questions</h2>
            <?php drawHomeButton();?>
        </header>
        <section class="faqs">
            <?php foreach($faqs as $faq){ ?>
                <article class = "faq" id = "faq<?=$faq->id ?>">
                    <p class = "questions"> <?= $faq->title ?></p>
                    <input type="button" id = "show<?=$faq->id?>" class = "faqShow" onclick = 'showFaq(<?=$faq->id?>);' value = "Show more">
                    <?php if ($agent){ ?>
                    <input type="button"  id = "edit<?=$faq->id?>" class = "faqEdit" onclick = 'openEditFaq(<?=$faq->id?>);' value = "Edit">
                    <?php } else {?>
                        <input type="button"  class = "faqEdit" value = "like">
                        <?php } ?>
                    <span id="<?=$faq->id ?>" class= "answer"> <?= $faq->content?></span>
                    <input type="button" id="saveButton<?=$faq->id ?>" class = "edit" onclick = 'editFaq(<?=$faq->id?>);' value = "Save">
                    
                </article>
                <?php } ?>
        </section>       
<?php }?>

<?php function drawHeaderMain(string $user){ ?>
    <h2> Hello <?= $user?> , </h2>
<?php }?>
