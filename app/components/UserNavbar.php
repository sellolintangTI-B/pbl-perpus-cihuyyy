<?php

namespace App\Components;

class UserNavbar
{
    public static function main($activeMenu = 'beranda', $userName = 'User', $logoUrl = null, $property = "")
    {
        include __DIR__ . '/html/user-navbar.php';
    }
    public static function navLink($label, $href, $active)
    {
        include __DIR__ . '/html/user-navlink.php';
    }
    // public static function profileDropdown($userName = 'User')
    // {
    //     include __DIR__ . '/html/navbar-profile-dropdown.php';
    // }
}
