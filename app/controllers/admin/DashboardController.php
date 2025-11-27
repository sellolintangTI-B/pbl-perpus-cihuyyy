<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Booking;
use App\Utils\Authentication;
use App\Utils\DB;

class DashboardController extends Controller
{

    public function index()
    {
        return $this->view('admin/dashboard/index', layoutType: $this::$layoutType['admin']);
    }


    public function search_book() {
        $activeBooking = [];
        if(isset($_GET['search'])) {
            $bookingCode = $_GET['search'];
            $activeBooking = Booking::getActiveBookingByBookingCode($bookingCode);
        }
        $json = json_encode($activeBooking);
        header('Content-Type: application/json');
        echo $json;
    }

    public function get_chart_data()
    {
        
    }
}
