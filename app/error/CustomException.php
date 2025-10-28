<?php

namespace app\error;
use Exception;
class  CustomException extends Exception {
    private $errors;

    public function __construct(string|array $data)
    {
        $this->errors = $data;
    }

    public function getErrorMessages()
    {
        return $this->errors;
    }
}