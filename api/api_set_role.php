<?php
    require_once(__DIR__ . '/../database/connection.db.php');

    $id = $_POST['id'];
    $role = $_POST['role'];

    $db = getDatabaseConnection();
    if($role == 'Admin'){
        $stmt = $db->prepare('UPDATE USER SET ISADMIN = 1, ISAGENT = 1, DEPARTMENT = "ADMINSTRATION" WHERE USERID = ?');
        $stmt->execute(array($id));
    } else if($role == 'Agent'){
        $stmt = $db->prepare('UPDATE USER SET ISADMIN = 0, ISAGENT = 1, DEPARTMENT = "SENATE" WHERE USERID = ?');
        $stmt->execute(array($id));
    } else {
        $stmt = $db->prepare('UPDATE USER SET ISADMIN = 0, ISAGENT = 0 WHERE USERID = ?');
        $stmt->execute(array($id));
    }

    echo 'Item updated successfully';
?>