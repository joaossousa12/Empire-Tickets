<?php declare(strict_types = 1); ?>

<?php function drawProfileHeader($session){ ?>
  <body class= "profile">
  <header>
  <?php drawHomeButton(); ?>
  <h2 class = "profile"> User Profile</h2>
  </header>
  <div class ="profile">
<?php }?>

<?php function getProfileImage(User $user){ 
  if (!file_exists("../docs/users/". $user->id . ".jpg")) {?>
        <img src = "../docs/users/default.jpeg" class="profile" alt = "profile">
<?php } else {?>
        <img src = "../docs/users/<?= $user->id ?>.jpg" class="profile" alt = "profile">
<?php }}?>

<?php function drawProfileLink(User $user){ ?>
    <a href="../pages/profile.php"> <?php getProfileImage($user); ?> </a>
<?php }?>

<?php function drawViewOfAllUsers(PDO $db, array $users) { ?>
  <section class="userRoles">
    <article class = "views">
    <h3> Clients </h3>
      <?php foreach($users as $user) {  
              if(!User::isAgent($db, $user->id)){?>
                  <div class="user-item">
                    <?= $user->name ?>  
                    <br>
                    <label class = "roleCol" for="role<?=$user->id?>"> Role: </label>
                    <select class = "rolesUser" id="role<?=$user->id?>" name="role" onchange = "updateRole(<?=$user->id ?>);">
                        <option value="Client" selected>Client</option>
                        <option value="Agent">Agent</option>
                        <option value="Admin">Admin</option>
                    </select>
                    <?php getProfileImage($user); ?>
                  </div>
        <?php } ?>
      <?php } ?>
    </article>
    <article class = "views">
    <h3> Agents </h3>
    <?php foreach($users as $user) {  
            if(User::isAgent($db, $user->id) && !User::isAdmin($db, $user->id)){?>
                <div class="user-item">
                  <?= $user->name ?>
                  <br>
                  <label class = "roleCol" for="role<?=$user->id?>"> Role: </label>
                    <select class = "rolesUser" id="role<?=$user->id?>" name="role" onchange = "updateRole(<?=$user->id ?>);">
                        <option value="Agent" selected>Agent</option>
                        <option value="Client">Client</option>
                        <option value="Admin">Admin</option>
                    </select>
                  <br>
                  <label class = "departmentCol" for="department<?=$user->id?>"> Department: </label>
                    <select class = "departmentsUser" id="department<?=$user->id?>" name="department" onchange = "updateAgentDepartment(<?=$user->id ?>);">
                    <?php $deps = Department::getDepartments($db);
                        foreach($deps as $department){ ?>
                        <option value=<?php echo ($department->id); if (User::getDepartment($db, $user->id) == $department->id) { echo ' selected'; } ?>> <?=$department->id ?> </option>
                        <?php } ?>
                    </select>
                  <?php getProfileImage($user); ?>
                </div>
      <?php } ?>
    <?php } ?>
    </article>
    <article class = "views">
    <h3> Admins </h3>
    <?php foreach($users as $user) {  
            if(User::isAdmin($db, $user->id)){?>
                <div class="user-item">
                  <?= $user->name ?>
                  <?php getProfileImage($user); ?>
                </div>
      <?php } ?>
    <?php } ?>
    </article>
  </section>
  </div>
<?php } ?>


<?php function drawSwitchToAdminView() { ?>
    <a id="switch" href="../pages/main_admin.php"> Switch to Admin View </a>
<?php } ?>

<?php function drawSwitchToAgentView() { ?>
  <div id="start">
    <a id="switch" href="../pages/main.php"> Switch to Agent View </a>
<?php } ?>

<?php function drawEditProfileForm(Session $session, User $user) { ?>
    <form action="../actions/action_edit_profile.php" method="post" class ="profile">
        <h3> Change profile info: </h3>

        <label for="Uname"> Name: </label>
        <input id="Uname" type="text" name="Uname" class = "profile" value="<?= $user->name ?>">

        <label for="Email"> Email: </label>
        <input id="Email" type="email" name="Email" class = "profile" value="<?= $user->email ?>">

        <label for="Password1"> Password: </label>
        <input id="Password1" type="password" name="Password1" class = "profile">

        <label for="Password2"> Reenter password: </label>
        <input id="Password2" type="password" name="Password2" class = "profile">
    
        <label for="submitNameChange"></label>
        <button id="submitNameChange" type="submit" class ="profile">Save</button>
    </form>

    <?php drawSessionMessages($session);?>
    </div>
<?php } ?>


