<?php

namespace App\Controllers\user;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\BookingParticipant;
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
                "user_id" => $user->user['id'],
                'room_id' => $id,
                "duration" => "12:00",
                "datetime" => "2025-11-12T11:03",
                "list_anggota" => [
                    [
                        "id" => "e1fd08b8-73dc-48b8-8f20-704d52ba8bc5",
                        "name" => "farrel maahira"
                    ],
                    [
                        "id" => "bad8bff9-1e5d-4038-84ea-350abeae8277",
                        "name" => "sello lintang"
                    ],
                    [
                        "id" => "bfe292f7-355a-4525-ad24-753aa6f7d1ac",
                        "name" => "Nabila Ananda"
                    ],
                    [
                        "id" => "0f593165-07e4-40af-aaf2-99ec521972af",
                        "name" => "Alya Putri"
                    ]
                ]
            ];

            $start = Carbon::parse($data['datetime']);
            $duration = Carbon::parse($data["duration"]);
            $data['duration'] = $start->diffInMinutes($duration);
            $data['datetime'] = $start->toDateTimeString();
            $members = $data['list_anggota'];
            unset($data['list_anggota']);

            $booking = Booking::create($data);
            $members = $this->addBookingIdToMembersData($members, $booking->id);
            $bookingLog = BookingLog::create($booking->id);
            $bookingParticipants = BookingParticipant::bulkInsert($members);

            ResponseHandler::setResponse("Berhasil menambahkan data");
            header("location:" . URL . '/user/room/index');
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:');
        }
    }

    private function addBookingIdToMembersData($members, $bookingId)
    {
        $members = array_map(function($item) use ($bookingId) {
            $item['booking_id'] = $bookingId;
            return $item;
        }, $members);
        return $members;
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
