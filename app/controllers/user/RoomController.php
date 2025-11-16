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
    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
    }
    public function index()
    {
        try {
            $params = [];
            
            if(isset($_GET['date'])) {
                $start = Carbon::parse($_GET['date']);
                $params['startTime'] = $start;
            }

            if(isset($_GET['duration'])) {
                $duration = Carbon::parse($_GET['duration'])->setDateFrom($start)->toDateTimeString();
                $params['duration'] = $start->diffInMinutes($duration);
            }

            if(isset($_GET['room'])) {
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
            if(isset($_GET['date'])) {
                $date = Carbon::parse($_GET['date'])->toDateString();
            } 
            $room = Room::getById($id);
            if (!$room) throw new CustomException("Data ruangan tidak ditemukan");
            $bookingSchedule = Booking::getByRoomId($id, $date);
            $data = [
                "detail" => $room,
                "schedule" => $bookingSchedule
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
