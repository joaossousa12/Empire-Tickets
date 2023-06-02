<?php 
    declare(strict_types = 1);

    class Department{
        public string $id;

        public function __construct(string $department){
            $this->id = $department;
        }

        static function getDepartments(PDO $db){
            $stmt = $db->prepare('SELECT DEPARTMENTID FROM DEPARTMENT');
            $stmt->execute(array());

            $departments = array();
            while ($dep = $stmt->fetch()){
                    $departments[] = new Department(
                        $dep['DEPARTMENTID']
                    );
            }

            return $departments;
        }

        static function createDepartment(PDO $db, string $dptmt) : ?Department{
            $stmt = $db->prepare('SELECT DEPARTMENTID FROM DEPARTMENT WHERE DEPARTMENTID = :department');
            
            $stmt->bindValue(':department', $dptmt, PDO::PARAM_STR);
            
            $stmt->execute();

            if($stmt->fetch()) return null;
            
            
            $stmt = $db->prepare('INSERT INTO DEPARTMENT(DEPARTMENTID) VALUES (:department)');
            
            $stmt->bindValue(':department', $dptmt, PDO::PARAM_STR);

            if($stmt->execute()){
                return new Department($dptmt);
            } else{
                return null;
            }
        }

        static function getAllDepartments(PDO $db) : array{
            $stmt = $db->prepare('SELECT DEPARTMENTID FROM DEPARTMENT');
            $stmt->execute();

            $departments = array();

            while($department = $stmt->fetch()){
                $departments[] = new Department($department['DEPARTMENTID']);
            }
            
            return $departments;
        }

    }
?>