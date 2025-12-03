<?php

namespace App\Controllers\User;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Utils\Authentication;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function index()
    {
        try {
            $params = [];

            if (isset($_GET['date'])) {
                if(!empty($_GET['date'])) {
                    if(empty($_GET['start_time'])) throw new CustomException('Harap masukan waktu mulai nya');
                    if(empty($_GET['end_time'])) throw new CustomException('Harap masukan waktu selesai nya');
                    $start = Carbon::parse($_GET['date']);
                    $params['start_time'] = $start->setTimeFromTimeString($_GET['start_time'])->toDateTimeString();
                    $duration = $start->setTimeFromTimeString($_GET['end_time']);
                    $params['duration'] = Carbon::parse($params['start_time'])->diffInMinutes($duration);
                }
            }

            if (isset($_GET['room'])) {
                $params['room'] = $_GET['room'];
            }

            $data = Room::get($params);
            $this->view('user/beranda/index', $data, layoutType: $this::$layoutType['civitas']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getMessage(), "error");
            header('location:' . URL . '/user/room/index');
        }
    }

    public function detail($id)
    {
        try {
            $date = Carbon::now('Asia/Jakarta')->toDateString();
            if (isset($_GET['date_check'])) {
                $date = Carbon::parse($_GET['date_check'])->toDateString();
            }
            $room = Room::getById($id);
            if (!$room) throw new CustomException("Data ruangan tidak ditemukan");
            $bookingSchedule = Booking::getByRoomId($id, $date);
            $data = [
                "detail" => $room,
                "schedule" => $bookingSchedule,
                "date" => $date
            ];
            $this->view('user/beranda/detail', $data, layoutType: $this::$layoutType['civitas']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            $error = ResponseHandler::getResponse();
            var_dump($error);
        }
    }

    public function getUserByNim($identifier)
    {
        try {
            $user = User::getByIdNumber($identifier);
            if (!$user) throw new CustomException("data user tidak tersedia");
            $data = [
                "success" => true,
                "data" => $user
            ];
            echo json_encode($data);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            $error = ResponseHandler::getResponse();
            var_dump($error);
        }
    }
}
