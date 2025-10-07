<?php

class ErrorHandler {
    public static function setError($error) {
        $_SESSION['errors'] = $error;
    }

    public static function getError() 
    {
        if(isset($_SESSION['errors'])) {
            return $_SESSION['errors'];
            unset($_SESSION['errors']);
        }
    }

}