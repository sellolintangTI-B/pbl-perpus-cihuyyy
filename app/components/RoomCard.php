<?php

namespace App\Components;

class RoomCard
{
    public static function card($room)
    {
        include __DIR__ . '/html/room-card.php';
    }
}
