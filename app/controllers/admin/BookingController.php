<?php

namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use app\error\CustomException;
use App\Models\Booking;
use App\Models\BookingLog;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $data = Booking::get();
            $this->view('admin/booking/index', $data, layoutType: "Admin");
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:');
        }
    }
    public function details($id)
    {
        try {
            $this->view('admin/booking/detail', layoutType: $this::$layoutType['admin']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:');
        }
    }
    public function create()
    {
        try {
            $this->view('admin/booking/create', layoutType: $this::$layoutType['admin']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:');
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
            header('location:');
        }
    }
}
