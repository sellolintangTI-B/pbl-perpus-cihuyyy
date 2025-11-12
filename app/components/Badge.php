<?php

namespace App\Components;

class Badge
{
    public static function badge($label, $active = false, $color = null, $class = '', $onclick = '', $type = '', $name = '', $value = '')
    {
        include __DIR__ . '/html/badge.php';
    }
}
