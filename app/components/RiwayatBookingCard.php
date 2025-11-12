<?php

namespace App\Components;

class RiwayatBookingCard
{
    public static function card($booking)
    {
        include __DIR__ . '/html/riwayat-booking-card.php';
    }
}
