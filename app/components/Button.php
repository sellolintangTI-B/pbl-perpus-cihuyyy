<?php

namespace App\Components;

class Button
{
    public static function anchor($label = '', $icon = null,  $class = '', $id = '', $href = '', $color = 'primary', $btn_icon_size = 'w-6 h-6')
    {
        include __DIR__ . '/html/anchor.php';
    }
    public static function  button($label = '', $btn_icon_size = 'w-6 h-6', $icon = null, $onClick = '', $type = '', $class = '', $name = '', $id = '', $color = 'primary', $alpineClick = '', $alpineDisabled = '')
    {
        include __DIR__ . '/html/button.php';
    }
    public static function anchorGradient($label = '', $icon = null, $link = '', $class = '')
    {
        include __DIR__ . '/html/gradient-anchor.php';
    }
    public static function buttonGradient($label = '', $icon = null, $onClick = '', $class = '', $type = '', $alpineClick = '')
    {
        include __DIR__ . '/html/gradient-button.php';
    }
}
