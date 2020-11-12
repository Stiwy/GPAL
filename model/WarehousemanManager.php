<?php
require_once 'Manager.php';

/**
 * WarehousemanManager;
 * Brings together all the functions needed to connect and disconnect users;
 * Extends Manager for using SQL query;
 */
class WarehousemanManager extends Manager
{   

    private $error = []; //Check all errors, and return in array
    private $success = []; //Check the success operation, and return in array

        
    /**
     * secureInput
     * Removes special character and target spaces to avoid security vulnerabilities;
     * @param  mixed $target
     * @return void
     */
    private function secureInput($target) {
        $target = htmlspecialchars($target); 
        $target = trim($target);
        $target = strip_tags($target); 

        return $target;
    }

	
	/**
	 * loginMember
	 * Checks the user's login data:
	 * @param  mixed $username
	 * @param  mixed $password
	 */
	public function loginMember($username, $password) 
    {
        if (session_status() == PHP_SESSION_NONE){session_start();}

        $username = $this->secureInput($username);

        $req = $this->pdoSelect("warehouseman", "username = ?", "NULL", $username);
        $user = $req->fetch();

        if (password_verify($password, $user['password'])) {

            if (empty($this->error)) { // Verify if one error exist 
                
                $cookie_name = "PHPUSERID";
                $cookie_value = $user['id'] . "---" . sha1($user['username'] . $user['password']);
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/", "bor.santedistri.com", false, true); //Create one cookie of 30 days for user 
                $_SESSION['warehouseman'] = $user;

                $this->success['login'] = "Vous êtes maintenant connecté !";
                $_SESSION['success'] = $this->success; //return success message
                header('Location: index.php');
            }else {
                $_SESSION['error'] = $this->error; //return error message
                header('Location: index.php');
            }
        }else {
            $this->rror['login'] = "Mot de passe incorrecte !";
            $_SESSION['error'] = $this->error;
            header('Location: index.php');
        }
    }
        
    /**
     * loginByCookieMember
     * Connect the member if cookie is correct
     * @return void
     */
    public function loginByCookieMember()
    {
        
        $auth = $_COOKIE['PHPUSERID'];
        $auth = explode("---", $auth);
        
        $req = $this->pdoSelect("warehouseman", "id = ?", "NULL", $auth['0']);
        $user = $req->fetch();
        $key = sha1($user['username'] . $user['password']);
        if ($key == $auth[1]) { // Verify if the $key is identiqual as key $auth[1]
            $_SESSION['warehouseman'] = $user;
        }
    }

    /**
     * logoutMember
     * Logout the member
     */
    public function logoutMember()
    {
        $this->success['logout'] = "Vous êtes maintenant déconnecté";

        if (session_status() == PHP_SESSION_NONE){session_start();}

        unset($_COOKIE['warehouseman']);
        unset($_SESSION['warehouseman']);

        $_SESSION['success'] = $this->success;
        header('location: index.php');
    }
}