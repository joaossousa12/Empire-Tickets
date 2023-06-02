<?php
    declare(strict_types = 1);

    class User{
        public int $id;
        public string $name;
        public string $email;
        public string $password;
        public string $profilePicPath;
        public string $userName;
    

        public function __construct(int $id, string $name, string $email, string $password, string $profilePicPath, string $userName){
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->profilePicPath = $profilePicPath;
            $this->userName = $userName;
        }

        function name() {
            return $this->name;
        }

        function save($db) {
            $stmt = $db->prepare('
              UPDATE USER SET NAME = ?, EMAIL = ?, PASSWORD = ?
              WHERE USERID = ?
            ');
      
            $stmt->execute(array($this->name, $this->email, $this->password, $this->id));
        }

        static function getUserWithPassword(PDO $db, string $email, string $password) : ?User{
            $stmt = $db->prepare('
                SELECT USERID, NAME, EMAIL, PASSWORD, PROFILEIMG, USERNAME
                FROM USER
                WHERE lower(EMAIL) = ?
            ');

            $stmt->execute(array(strtolower($email)));
            $user = $stmt->fetch();

            if(!$user) return null;

            if(password_verify($password, $user['PASSWORD'])){
                return new User(
                    $user['USERID'],
                    $user['NAME'],
                    $user['EMAIL'],
                    $user['PASSWORD'],
                    $user['PROFILEIMG'],
                    $user['USERNAME']
                );
            } else return null;
        }

        static function getUser(PDO $db, int $id) : User {
            $stmt = $db->prepare('
                SELECT USERID, NAME, EMAIL, PASSWORD, PROFILEIMG, USERNAME
                FROM USER 
                WHERE USERID = ?
            ');

            $stmt->execute(array($id));
            $user = $stmt->fetch();

            return new User(
                $user['USERID'],
                $user['NAME'],
                $user['EMAIL'],
                $user['PASSWORD'],
                $user['PROFILEIMG'],
                $user['USERNAME']
            );
        }

        static function createUser(PDO $db, string $name, string $email, string $password, string $userName) : ?User{
            $stmt = $db->prepare('SELECT EMAIL FROM USER WHERE lower(EMAIL) = ?');

            $stmt->execute(array(strtolower($email)));

            if($user = $stmt->fetch()) return null;

            $stmt = $db->prepare('SELECT USERNAME FROM USER WHERE USERNAME = ?');

            $stmt->execute(array($userName));

            if($user = $stmt->fetch()) return null;

            $stmt = $db->prepare('SELECT MAX(USERID) as maxid FROM USER');
            $stmt->execute();
            $user = $stmt->fetch();

            $id = $user['maxid'] + 1;
            $defaultImg = '../docs/users/default.jpeg';

            $stmt = $db->prepare('INSERT INTO USER (USERID, USERNAME, NAME, EMAIL, PASSWORD, ISAGENT, ISADMIN, PROFILEIMG) 
         VALUES (:id, :username, :name, :email, :password, 0, 0, :profileimg)'); // 0 0 because it's a normal user registering

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':username', $userName, PDO::PARAM_STR);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $hash, PDO::PARAM_STR);
            $stmt->bindValue(':profileimg', $defaultImg, PDO::PARAM_STR);

            if($stmt->execute()) {
                return new User($id, $name, $email, $hash, $defaultImg, $userName);
            } else {
                return null;
            }
        }

        static function getName(PDO $db, int $id) : string{
            $stmt = $db->prepare('SELECT NAME FROM USER WHERE USER.USERID == ? LIMIT 1' );
            $stmt->execute(array($id));
  
            $name = $stmt->fetch();
  
            return $name['NAME'];
        }

        static function isAgent(PDO $db, int $id) : bool{
            $stmt = $db->prepare('SELECT ISAGENT FROM USER WHERE USERID = ?');
            $stmt->execute(array($id));

            $isAgent = $stmt->fetch();
            if($isAgent['ISAGENT'] == 1) return true;
            else return false;
        }

        static function isAdmin(PDO $db, int $id) : bool{
            $stmt = $db->prepare('SELECT ISADMIN FROM USER WHERE USERID = ?');
            $stmt->execute(array($id));

            $isAdmin = $stmt->fetch();

            if($isAdmin['ISADMIN'] == 1) return true;
            else return false;;
        }

        static function getDepartment(PDO $db, int $id) : string{
            $stmt = $db->prepare('SELECT DEPARTMENT FROM USER WHERE USERID = ? LIMIT 1' );
            $stmt->execute(array($id));
  
            $department = $stmt->fetch();
  
            return $department['DEPARTMENT'];
        }

        static function getAgentsFromDptmt(PDO $db, string $dep) : array{
            $stmt = $db->prepare('SELECT USERID, NAME, EMAIL, PASSWORD, PROFILEIMG, USERNAME FROM USER WHERE DEPARTMENT = ?');
            $stmt->execute(array($dep));
            

            $users = array();

            while($user = $stmt->fetch()){
                $users[] = new User(
                    $user['USERID'],
                    $user['NAME'],
                    $user['EMAIL'],
                    $user['PASSWORD'],
                    $user['PROFILEIMG'],
                    $user['USERNAME']
                ); 
            }

            return $users;
        }

        static function getAllUsers(PDO $db) : array{
            $stmt = $db->prepare('SELECT * FROM USER');
            $stmt->execute();
            

            $users = array();

            while($user = $stmt->fetch()){
                $users[] = new User(
                    $user['USERID'],
                    $user['NAME'],
                    $user['EMAIL'],
                    $user['PASSWORD'],
                    $user['PROFILEIMG'],
                    $user['USERNAME']
                ); 
            }

            return $users;
        }
    }
?>