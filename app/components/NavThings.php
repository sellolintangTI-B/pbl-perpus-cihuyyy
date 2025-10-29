<?php
namespace App\Components;
class NavThings {
    public static function adminNavLink($active, $label, $icon, $href = "#"){
        include __DIR__ . '/html/admin-nav-link.php';
    }
    public static function adminSideBar($items = [], $activeItem = null, $title = "SIMARU", $logo = null){
        include __DIR__ . '/html/admin-sidebar.php';
    }
}