<?php
class Modal{
    public static function confirmation(
        $trigger = "open", 
        $title = "", 
        $message = "", 
        $type = ""  
        ){
        include __DIR__ . '/html/modal.php'; 
    }
}