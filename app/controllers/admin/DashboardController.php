<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use app\error\CustomException;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Utils\Authentication;
use App\Utils\DB;
use App\Utils\Mailer;
use PDO;

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

    public function get_barChart_data()
    {
        try {
            $barChart = Booking::getDataForRoomsPerYearChart();
            $finalData = [];
            //        "Ruangan 1": {
            //            "2023": 95,
            //            "2024": 34,
            //            "2025": 29
            //          },

            foreach ($barChart as $row) {
                $name = $row->name;
                $finalData[$name] = [];
                foreach ($barChart as $row) {
                }
            }
            header('Content-Type: application/json');
            echo json_encode($barChart);
        } catch (CustomException $e) {
        }
    }

    public function check_in($bookingId)
    {
        try {
            $checkIn = BookingLog::checkIn($bookingId);
            if ($checkIn) {
                ResponseHandler::setResponse('Checkin berhasil');
                header('location:' . URL . '/admin/dashboard/index');
            } else {
                ResponseHandler::setResponse('Gagal checkin');
                header('location:' . URL . '/admin/dashboard/index');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/dashboard/index');
        }
    }

    public function check_out($bookingId)
    {
        try {
            $checkOut = BookingLog::checkOut($bookingId);
            if ($checkOut) {
                ResponseHandler::setResponse('Checkout berhasil');
                header('location:' . URL . '/admin/dashboard/index');
            } else {
                ResponseHandler::setResponse('Gagal checkout');
                header('location:' . URL . '/admin/dashboard/index');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/dashboard/index');
        }
    }

    public function cancel($bookingId)
    {
        if (empty($bookingId)) {
            ResponseHandler::setResponse('booking id tidak ditemukan! ' . $bookingId, 'error');
            $this->redirectWithOldInput('/admin/booking/index');
        }
        try {
            $user = new Authentication;
            $data = [
                'user_id' => $user->user['id'],
                'reason' => $_POST['reason'],
                'booking_id' => $bookingId
            ];
            $cancel = BookingLog::cancel($data);
            if ($cancel) {
                ResponseHandler::setResponse('Berhasil membatalkan peminjaman ruangan');
                header('location:' . URL . '/admin/booking/index');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/booking/index');
        }
    }
}
