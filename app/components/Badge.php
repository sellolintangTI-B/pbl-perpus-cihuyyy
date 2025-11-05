<?php
namespace App\Components;
class Badge {
    public static function badge($label, $active=true) {
        include __DIR__ . '/html/badge.php';
    }
}
?>