<?php

class  CustomException extends Exception {
    private $errors;

    public function __construct(string|array $data, $message = null)
    {
        $this->errors = $data;
    }

    public function getErrorMessages()
    {
        return $this->errors;
    }
}