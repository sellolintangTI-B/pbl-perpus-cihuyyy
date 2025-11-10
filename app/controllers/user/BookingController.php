<?php

namespace App\Controllers\user;

use App\Core\Controller;

class BookingController extends Controller
{

    public function index()
    {
        $this->view('user/booking/index',  layoutType: $this::$layoutType["civitas"]);
    }
}
