<?php

namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use app\error\CustomException;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Utils\Authentication;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $data = Booking::get();
            $this->view('admin/booking/index', $data, layoutType: "Admin");
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/dashboard/index');
        }
    }
    public function details($id)
    {
        try {
            $this->view('admin/booking/detail', layoutType: $this::$layoutType['admin']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/booking/index');
        }
    }
    public function create()
    {
        try {
            $this->view('admin/booking/create', layoutType: $this::$layoutType['admin']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/booking/create');
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
        try {
            $user = new Authentication;
            $data = [
                'user_id' => $user->user['id'],
                'reason' => 'Pengguna malas',
                'booking_id' => $bookingId
            ];
            $cancel = BookingLog::cancel($data);
            if ($cancel) {
                ResponseHandler::setResponse('Berhasil membatalkan peminjaman ruangan');
                header('location:' . URL . '/admin/dashboard/index');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/dashboard/index');
        }
    }
}
