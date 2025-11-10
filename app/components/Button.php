<?php

namespace App\Components;

class Button
{
    public static function anchor($label = '', $icon = null,  $class = '', $id = '', $href = '', $color = 'primary')
    {
        include __DIR__ . '/html/anchor.php';
    }
    public static function  button($label = '', $icon = null, $onClick = '', $type = '', $class = '', $name = '', $id = '', $href = '', $color = 'primary')
    {
        include __DIR__ . '/html/button.php';
    }
}
