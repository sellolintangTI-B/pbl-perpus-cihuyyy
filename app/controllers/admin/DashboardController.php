<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Booking;
use App\Utils\Authentication;
use App\Utils\DB;

class DashboardController extends Controller
{

    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
    }
    public function index()
    {
        $activeBooking = [];
        if(isset($_GET['search'])) {
            $bookingCode = $_GET['search'];
            $activeBooking = Booking::getActiveBookingByBookingCode($bookingCode);
        }
        return $this->view('admin/dashboard/index', $activeBooking ,layoutType: $this::$layoutType['admin']);
    }


    public function approved() {}
}
