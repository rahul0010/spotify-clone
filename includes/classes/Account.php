<?php

class Account
{
    private $errorArray;
    public function __construct()
    {
        $this->$errorArray = array();
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
            return true;
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
        
    private function validateUsername($username)
    {
        if(strlen($username) > 25 || strlen($username) < 5)   
        {
            array_push($this->errorArray, "Your username must be between 5 and 25 characters");
            return;
        }
        
        //TODO: Check username already being used
    }

    private function validateFirstname($firstName)
    {
        if(strlen($firstName) > 25 || strlen($firstName) < 2)   
        {
            array_push($this->errorArray, "Your first name must be between 2 and 25 characters");
            return;
        }
    }

    private function validateLastname($lastName)
    {
        if(strlen($lastName) > 25 || strlen($lastName) < 2)   
        {
            array_push($this->errorArray, "Your last name must be between 5 and 25 characters");
            return;
        }
    }

    private function validateEmails($em, $em2)
    {
        if($em != $em2)
        {
            array_push($this->errorArray, "Your emails don't match");
            return;
        }
        if(!filter_var($em, FILTER_VALIDATE_EMAIL))
        {
            array_push($this->errorArray, "Email is invalid");
            return;
        }

        //TODO: Check username already being used

    }

    private function validatePasswords($pw, $pw2)
    {
        if($pw != $pw2)
        {
            array_push($this->errorArray, "Your passwords don't match");
            return;
        }

        if(preg_match('/[^A-Za-z0-9]/',$pw))
        {
            array_push($this->errorArray, "Your passwords can only contain numbers and letters");
            return;
        }

        if(strlen($pw) > 30 || strlen($pw) < 5)   
        {
            array_push($this->errorArray, "Your password must be between 5 and 30 characters");
            return;
        }
    }
        
}

?>