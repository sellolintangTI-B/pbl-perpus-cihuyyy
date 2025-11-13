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
use App\Utils\Validator;
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
                "datetime" => $_POST['datetime'], 
                "duration" => $_POST['duration'],
                "end_time" => "",
                "booking_code" => "ABCD1",
                "list_anggota" => json_decode($_POST['list_anggota'], true)            
            ];


            $validator = new Validator($data);
            $validator->field('datetime', ['required']);
            $validator->field('duration', ['required']);
            if($validator->error()) throw new CustomException($validator->getErrors());

            $start = Carbon::parse($data['datetime']);
            $duration = Carbon::today('Asia/Jakarta')->setTimeFromTimeString($data['duration']);
            $duration = $duration->toDateTimeString();
            $data['datetime'] = $start->toDateTimeString();
            $data['duration'] = $start->diffInMinutes($duration);
            $data['end_time'] = $start->addMinutes($data['duration'])->toDateTimeString();


            if($data['duration'] < 60) throw new CustomException('Minimal durasi pinjam ruangan 1 jam');
            if($data['duration'] > 180) throw new CustomException('Maximal durasi pinjam ruangan 3 jam');

            $checkIfScheduleExists = Booking::checkSchedule($data['datetime'], $data['duration'], $id);
            if($checkIfScheduleExists) throw new CustomException('Jadwal sudah dibooking');

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
            header('location:' . URL . '/user/room/detail/' . $id);
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
