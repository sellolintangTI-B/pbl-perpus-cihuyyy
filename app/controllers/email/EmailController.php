<?php

namespace App\Controllers\email;

use App\Core\Controller;

class EmailController extends Controller
{
    public function reset_password()
    {
        $this->view('email/reset-password');
    }
    public function booking_cancel()
    {
        $this->view('email/booking-cancel');
    }
    public function booking_code()
    {
        $this->view('email/booking-code');
    }
}
