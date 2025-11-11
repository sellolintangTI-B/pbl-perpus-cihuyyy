<?php

namespace App\Controllers\user;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\User;
use App\Utils\Authentication;
use Carbon\Carbon;

class BookingController extends Controller
{

    public function index()
    {
        $this->view('user/booking/index',  layoutType: $this::$layoutType["civitas"]);
    }

    public function store($id)
    {
        try {
            $user = new Authentication;
            $data = [
                "date" => "2025-11-10T09:00",
                "pic_id" => $user->user['id'],
                'room_id' => $id,
                "duration" => "11:00",
                'members' => [
                    "e1fd08b8-73dc-48b8-8f20-704d52ba8bc5"
                ]
            ];

            $start = Carbon::parse($data['date']);
            $duration = Carbon::parse($data["duration"]);
            $data['duration'] = $start->diffInMinutes($duration);
            $data['start_time'] = $start->toDateTimeString();
            $members = $data['members'];

            $booking = Booking::create($data);
            $bookingLog = BookingLog::create($booking->id);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:');
        }
    }

    public function search_user($identifier)
    {
        try {
            $user = User::getByIdNumber($identifier);
            if (!$user) throw new CustomException("data user tidak tersedia");
            $data = [
                "success" => true,
                "data" => $user
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
        } catch (CustomException $e) {
            $error = json_encode($e->getErrorMessages());
            echo $error;
        }
    }
}
