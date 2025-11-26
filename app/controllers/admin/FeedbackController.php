<?php

namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use app\error\CustomException;
use App\Models\Feedback;
use App\Models\Room;
use Carbon\Carbon;

class FeedbackController extends Controller
{
    public function index()
    {
        try {
            $params = [];
            if (isset($_GET['room'])) {
                $params['room'] = $_GET['room'];
            }

            if (isset($_GET['date'])) {
                $params['date'] = Carbon::parse($_GET['date'])->format('Y-m-d');
            }
            $feedback = Feedback::get($params);
            $data = [
                'feedback' => $feedback,
                'room' => Room::get()
            ];
            $this->view('/admin/feedback/index', $data, 'Admin');
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getMessage(), 'error');
            header('location:' . URL . '/admin/feedback/index');
        }
    }
}
