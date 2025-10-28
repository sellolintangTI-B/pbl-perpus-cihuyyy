<?php
namespace App\Components;
class FormInput {
    public static function input($id = '', $name = '', $type ='text', $label = '', $value = '', $placeholder = '', $class = '', $classGlobal = '', $required = false, $readonly = false, $disabled = false) {
    include __DIR__ . '/html/text-input.php';
    }
    public static function fileInput($id = '', $name = '', $type ='text', $label = '', $value = '', $placeholder = '', $class = '', $classGlobal = '', $required = false, $readonly = false, $disabled = false, $accept = null) {
    include __DIR__ . '/html/file-input.php';
    }
    public static function select($id = '', $name = '', $value = '', $options = [["display"=> null, "value" =>null]], $placeholder = '', $label = '', $required = false, $class = '', $classGlobal = '', $disabled = false, $selected = ''){
    include __DIR__ . '/html/select-option.php';
    }
}

