<?php

class Validator {
    private $data;
    private $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function field($field, $rules = []) 
    {
        foreach($rules as $rule) {
            $error = call_user_func([$this, $rule], $field);
            if(!empty($error)) {
                if(!empty($this->errors[$field])) {
                    return;
                }
                $this->errors[$field] = $error;
            }
        }
    }

    public function email($field) {
        if(!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            return "Please insert a valid email";
        }
    }

    public function required($field) {
        if(empty($this->data[$field])) {
            return "$field is required";
        }
    }

    public function minLength($field, $length) {
        if(strlen($this->data[$field]) < $length) {
            return "$field must be at least $length characters long";
        }
    }

    public function error() 
    {
        if(!empty($this->errors)) {
            return true;
        } 
        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}