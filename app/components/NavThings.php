<?php
namespace app\components;
class NavThings{
    public static function adminNavLink($active, $label, $icon, $href = "#"){
        include __DIR__ . '/html/nav-link.php';
    }
    public static function adminSideBar($items = [], $activeItem = null, $title = "SIMARU", $logo = null){
        include __DIR__ . '/html/sidebar.php';
    }
}