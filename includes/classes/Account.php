<?php

class Account
{
    private $con;
    private $errorArray;
    public function __construct($con)
    {
        $this->con = $con;
        $this->errorArray = array();
    }

    public function login($username, $password)
    {
        $password = md5($password);
        $query = mysqli_query($this->con, "select * from users where username='$username' and password='$password'");
        if(mysqli_num_rows($query) == 1)
        {
            return true;
        }
        else
        {
            array_push($this->errorArray, Constants::$loginFailed);
            return false;
        }
    }
    
    public function register($username, $firstName, $lastName, $email, $email2, $password, $password2)
    {
        $this->validateUsername($username);
        $this->validateFirstname($firstName);
        $this->validateLastname($lastName);
        $this->validateEmails($email, $email2);
        $this->validatePasswords($password, $password2);

        if(empty($this->errorArray))
        {
            // Insert into db
            return $this->insertUserDetails($username, $firstName, $lastName, $email, $password);
        }
        else
        {
            return false;
        }
    }

    public function getError($error)
    {
        if(!in_array($error, $this->errorArray))
        {
            $error = "";
        }

        return "<span class='errorMessage'>$error</span>";
    }

    private function insertUserDetails($username, $firstName, $lastName, $email, $password)
    {
        $encryptedPw = md5($password);
        $profilePic = "assets/images/profile-pics/head_emrald.png";
        $date = date("Y-m-d");

        $result = mysqli_query($this->con, "insert into users values('','$username','$firstName','$lastName','$email','$encryptedPw','$date','$profilePic')");
        return $result;
    }
        
    private function validateUsername($username)
    {
        if(strlen($username) > 25 || strlen($username) < 5)   
        {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }
        
        $checkUsernameQuery = mysqli_query($this->con, "select username from users where username = '$username'");
        if(mysqli_num_rows($checkUsernameQuery) != 0)
        {
            array_push($this->errorArray, Constants::$usernameTaken);
            return;
        }
    }

    private function validateFirstname($firstName)
    {
        if(strlen($firstName) > 25 || strlen($firstName) < 2)   
        {
            array_push($this->errorArray, Constants::$firstNameCharacters);
            return;
        }
    }

    private function validateLastname($lastName)
    {
        if(strlen($lastName) > 25 || strlen($lastName) < 2)   
        {
            array_push($this->errorArray, Constants::$lastNameCharacters);
            return;
        }
    }

    private function validateEmails($em, $em2)
    {
        if($em != $em2)
        {
            array_push($this->errorArray, Constants::$emailsDoNotMatch);
            return;
        }
        if(!filter_var($em, FILTER_VALIDATE_EMAIL))
        {
            array_push($this->errorArray, Constant::$emailInvalid);
            return;
        }

        $checkEmailQuery = mysqli_query($this->con, "select username from users where email = '$em'");
        if(mysqli_num_rows($checkEmailQuery) != 0)
        {
            array_push($this->errorArray, Constants::$emailTaken);
            return;
        }

    }

    private function validatePasswords($pw, $pw2)
    {
        if($pw != $pw2)
        {
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
            return;
        }

        if(preg_match('/[^A-Za-z0-9]/',$pw))
        {
            array_push($this->errorArray, Constants::$passwordAlphaNumeric);
            return;
        }

        if(strlen($pw) > 30 || strlen($pw) < 5)   
        {
            array_push($this->errorArray, Constants::$passwordCharacters);
            return;
        }
    }
        
}

?>