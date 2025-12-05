<?php

namespace App\Components;

class FormInput
{
    public static function input($id = '', $name = '', $type = 'text', $label = '', $value = '', $placeholder = '', $class = '', $classGlobal = '', $required = false, $readonly = false, $disabled = false, $color = '', $alpine_xmodel = '', $alpine_disabled = false)
    {
        include __DIR__ . '/html/text-input.php';
    }
    public static function fileInput($id = '', $name = '', $type = 'text', $label = '', $value = '', $placeholder = '', $class = '', $classGlobal = '', $required = false, $readonly = false, $disabled = false, $accept = null, $alpine_disabled = false)
    {
        include __DIR__ . '/html/file-input.php';
    }
    public static function select($id = '', $name = '', $value = '', $options = [["display" => null, "value" => null]], $placeholder = '', $label = '', $required = false, $class = '', $classGlobal = '', $disabled = false, $selected = '', $color = '', $readonly = false, $alpine_disabled = false, array $attributes = [])
    {
        include __DIR__ . '/html/select-option.php';
    }
    public static function textarea($id = '', $name = '', $label = '', $value = '', $placeholder = '', $class = '', $classGlobal = '', $rows = 4, $required = false, $readonly = false, $disabled = false, $maxlength = null, $color = '', $alpine_disabled = false)
    {
        include __DIR__ . '/html/text-area.php';
    }
    public static function checkbox($id = '', $name = '', $label = '', $value = '1', $checked = false, $class = '', $classGlobal = '', $required = false, $disabled = false, $color = '')
    {
        include __DIR__ . '/html/checkbox.php';
    }
}
