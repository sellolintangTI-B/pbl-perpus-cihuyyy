<?php

namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use app\error\CustomException;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $this->view('admin/booking/index', layoutType: "Admin");
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
}
