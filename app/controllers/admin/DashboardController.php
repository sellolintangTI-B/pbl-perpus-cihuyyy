<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use app\error\CustomException;
use App\Models\Booking;
use App\Utils\Authentication;
use App\Utils\DB;
use App\Utils\Mailer;

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

    public function mail()
    {
        try {
            Mailer::send('farrelmaahira104@gmail.com', 'testing', '<h1> testing mail </h1>');
            header('location:' . URL . '/admin/dashboard');
        } catch (CustomException $e) {
            var_dump($e->getErrorMessages());
            die;
        }
    }
}
