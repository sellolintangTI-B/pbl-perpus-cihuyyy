<?php
namespace App\Core;
class ResponseHandler {

    public static function setResponse($message, $type = "success") {
        $_SESSION['response'] = [
            "type" => $type,
            "message" => $message
        ];
    }

    public static function getResponse() 
    {
        if(isset($_SESSION['response'])) {
            $response = $_SESSION['response'];
            unset($_SESSION['response']);
            return $response;
        }
    }

}