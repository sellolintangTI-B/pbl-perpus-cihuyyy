<?php

class Authentication {
    public $user = [];

    public function __construct()
    {
        if(isset($_SESSION['loggedInUser']))  {
            $this->user = $_SESSION['loggedInUser'];
        }
    }

    public function logout()
    {
        if(isset($_SESSION['loggedInUser']))  {
            unset($_SESSION['loggedInUser']);
            return true;
        }

        return false;
    }

}