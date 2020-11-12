<?php

require_once '../model/Manager.php';

Class AdminGPALManager extends Manager 
{    
   public function registerMember($username, $password, $passwordConfirm)
    {
        $db = $this->dbConnect();
        $error = [];
        $success = [];

        if (empty($username) || empty($password) || empty($passwordConfirm) || is_null($username) || is_null($password) || is_null($passwordConfirm)) {
            $error['empty'] = 'Veuillez remplir tous les champs ci-dessous !';
        }else {
            $username = htmlspecialchars($username); 
            $username = trim($username);
            $username = strip_tags($username); 
            
            $req = $db->prepare('SELECT username FROM warehouseman WHERE username = ?');
            $req->execute(array($username));

            if ($req->rowCount() != 0) {
                $error['username'] = 'Identifiant déjà utilisé !';
            }
        }
        
       
        if ($password != $passwordConfirm) {
            $error['password'] = 'Le mot de passe de confirmation est incorrecte !';
        }
        
        if (empty($error)) {
            
            $passwordCrypt = password_hash($password, PASSWORD_BCRYPT);
            
            do {
                $id = uniqid((double)microtime()*1000000, true);
                $req = $db->prepare('SELECT id FROM warehouseman WHERE id = ?');
                $req->execute(array($id));
                $testResult = $req->rowCount();
            }while ($testResult != 0);
            
            $member = $db->prepare('INSERT INTO warehouseman(id, username, password, inssert_date) VALUES(?, ?, ?, now())');
            $affectLines = $member->execute(array($id, $username, $passwordCrypt));

            $success['register'] = 'Ajout réussit';
            $_SESSION['success'] = $success; 
        }else {
            $_SESSION['error'] = $error;
        }     
    }
}

