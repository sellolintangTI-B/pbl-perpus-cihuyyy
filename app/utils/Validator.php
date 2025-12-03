<?php

namespace App\Utils;


class Validator
{
    private $data;
    private $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function field($field, $rules = [])
    {
        foreach ($rules as $rule) {
            $error = call_user_func([$this, $rule], $field);
            if (!empty($error)) {
                if (!empty($this->errors[$field])) {
                    return;
                }
                $this->errors[$field] = $error;
            }
        }
    }

    public function email($field)
    {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            return "Please insert a valid email";
        }
    }

    public function captcha($field) 
    {
        if (empty($this->data[$field])) {
            return "Permintaan ditolak. Harap konfirmasi bahwa Anda bukan robot.";
        }
    }

    public function password($field)
    {
        $password = $this->data[$field];
        $validPass = true;
        if (strlen($password) < 8) $validPass = false;
        
        if (!preg_match('/[A-Z]/', $password)) $validPass = false;
        

        if (!preg_match('/[a-z]/', $password)) $validPass = false;
        

        if (!preg_match('/[0-9]/', $password)) $validPass = false;
        
        if (!preg_match('/[!@#$%^&*()]/', $password)) $validPass = false;

        if(!$validPass) {
            return "Password harus terdiri dari minimal 8 karakter, mengandung huruf kecil (a-z), huruf besar (A-Z), angka (0-9), dan karakter spesial (!@#$%^&*())";
        }
    }

    public function required($field)
    {
        if (empty($this->data[$field])) {
            return "$field is required";
        }
    }

    public function int($field)
    {
        if (!is_integer($this->data[$field])) {
            return "$field have to be a number";
        }
    }

    public function minLength($field, $length)
    {
        if (strlen($this->data[$field]) < $length) {
            return "$field must be at least $length characters long";
        }
    }

    public function error()
    {
        if (!empty($this->errors)) {
            return true;
        }
        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
