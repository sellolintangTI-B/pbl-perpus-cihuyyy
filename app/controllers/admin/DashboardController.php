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


    public function search_book()
    {
        $activeBooking = [];
        if (isset($_GET['search'])) {
            $bookingCode = $_GET['search'];
            $activeBooking = Booking::getActiveBookingByBookingCode($bookingCode);
        }
        $json = json_encode($activeBooking);
        header('Content-Type: application/json');
        echo $json;
    }

    public function get_chart_data()
    {
        try {
            $linechart = Booking::getDataForLineChart();
            $finalData = [];

            foreach ($linechart as $row) {
                $year = $row->year;
                $month = (int) $row->month;
                $total = (int) $row->count;
                if (!isset($finalData[$year])) {
                    $finalData[$year] = array_fill(0, 12, 0);
                }

                $finalData[$year][$month - 1] = $total;
            }
            header('Content-Type: application/json');
            echo json_encode($finalData);
        } catch (CustomException $e) {
            header('Content-Type: application/json');
            echo json_encode($e->getErrorMessages());
        }
    }

    public function mail()
    {
        try {
            Mailer::send('mahasisw@example.com', 'testing', '<h1> testing mail </h1>');
            header('location:' . URL . '/admin/dashboard');
        } catch (CustomException $e) {
            var_dump($e->getErrorMessages());
            die;
        }
    }
}
