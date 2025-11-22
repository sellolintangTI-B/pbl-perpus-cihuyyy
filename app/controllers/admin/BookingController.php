<?php

namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\BookingParticipant;
use App\Models\Room;
use App\Models\User;
use App\Utils\Authentication;
use App\Utils\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $data = Booking::get();
            $this->view('admin/booking/index', $data, layoutType: "Admin");
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/booking/index');
        }
    }
    public function details($id)
    {
        try {
            $booking = Booking::getById($id);
            $bookingParticipants = BookingParticipant::getParticipantsByBookingId($id);
            if ($booking->status == 'cancelled') {
                $detailCancel = BookingLog::getCancelDetailByBookingId($id);
            }
            if ($booking->status == 'finished') {
                $detailFinished = BookingLog::getFinishedDetailByBookingId($id);
            }
            $data = [
                'booking' => $booking,
                'status' => $booking->status,
                'bookingParticipants' => $bookingParticipants,
                'detailCancel' => $detailCancel[0] ?? null,
                'detailFinished' => $detailFinished ?? null,
            ];

            $this->view('admin/booking/detail', $data, layoutType: $this::$layoutType['admin']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/booking/index');
        }
    }

    public function create()
    {
        try {
            $params = [];
            $state = 'room';
            $data = [
                'data' => null,
                'state' => $state,
                'roomList' => []
            ];

            if (isset($_GET['date'])) {
                $start = Carbon::parse($_GET['date']);
                $params['startTime'] = $start;
            }

            if (isset($_GET['duration'])) {
                $duration = Carbon::parse($_GET['duration'])->setDateFrom($start)->toDateTimeString();
                $params['duration'] = $start->diffInMinutes($duration);
            }

            if (isset($_GET['room'])) {
                $params['room'] = $_GET['room'];
            }

            if (isset($_GET['state']) && $_GET['state'] == 'detail' && isset($_GET['id'])) {
                $data['data'] = Room::getById($_GET['id']);
                $data['roomList'] = Room::get();
                $data['state'] = 'detail';
            } else {
                $data['data'] = Room::get($params);
                $data['state'] = 'room';
            };
            $this->view('admin/booking/create/create', $data, layoutType: $this::$layoutType['admin']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getMessage(), "error");
            header('location:' . URL . '/admin/booking/create');
        }
    }

    public function store()
    {
        try {
            $data = [
                "user_id" => "",
                'room_id' => $_POST['room'],
                "datetime" => $_POST['datetime'],
                "duration" => $_POST['duration'],
                "end_time" => "",
                "list_anggota" => json_decode($_POST['list_anggota'], true)
            ];
            $data['user_id'] = $data['list_anggota'][0]['id'];

            $validator = new Validator($data);
            $validator->field('datetime', ['required']);
            $validator->field('duration', ['required']);
            if ($validator->error()) throw new CustomException($validator->getErrors());

            $start = Carbon::parse($data['datetime']);
            $end = Carbon::parse($data['duration'])->setDateFrom($start);
            $data['datetime'] = $start->toDateTimeString();
            $data['duration'] = $start->diffInMinutes($end);
            $data['end_time'] = $start->copy()->addMinutes($start->diffInMinutes($end))->toDateTimeString();

            $rules = $this->validationBookingRules($data['room_id'], $data);
            if (!$rules['status']) throw new CustomException($rules['message']);

            $members = $data['list_anggota'];
            $data['booking_code'] = $this->generateBookingCode();
            unset($data['list_anggota']);

            $booking = Booking::create($data);
            $members = $this->addBookingIdToMembersData($members, $booking->id);
            $bookingLog = BookingLog::create($booking->id);
            $bookingParticipants = BookingParticipant::bulkInsert($members);

            ResponseHandler::setResponse("Berhasil menambahkan data");
            header("location:" . URL . '/admin/booking/index');
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/booking/create');
        }
    }

    private function generateBookingCode()
    {
        $characters = 'ABCDFGHIJKLN01234567890';
        $code = '';

        for ($i = 0; $i < 5; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }

    private function addBookingIdToMembersData($members, $bookingId)
    {
        $members = array_map(function ($item) use ($bookingId) {
            $item['booking_id'] = $bookingId;
            return $item;
        }, $members);
        return $members;
    }

    private function validationBookingRules($roomId, $data)
    {
        try {
            $roomDetail = Room::getById($roomId);
            if (Carbon::parse($data['datetime'])->lt(Carbon::now('Asia/Jakarta')->toDateString())) throw new CustomException('Tidak bisa booking di kemarin hari');
            if ($data['duration'] < 60) throw new CustomException('Minimal durasi pinjam ruangan 1 jam');
            if ($data['duration'] > 180) throw new CustomException('Maximal durasi pinjam ruangan 3 jam');

            $checkIfScheduleExists = Booking::checkSchedule($data['datetime'], $data['duration'], $roomId);
            if ($checkIfScheduleExists) throw new CustomException('Jadwal sudah dibooking');

            if (count($data['list_anggota']) < $roomDetail->min_capacity) throw new CustomException("Minimal kapasitas adalah $roomDetail->min_capacity orang");
            if (count($data['list_anggota']) > $roomDetail->max_capacity) throw new CustomException("Maximal kapasitas adalah $roomDetail->max_capacity orang");

            return [
                'status' => true
            ];
        } catch (CustomException $e) {
            return [
                "status" => false,
                "message" => $e->getErrorMessages()
            ];
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

    public function check_in($bookingId)
    {
        try {
            $checkIn = BookingLog::checkIn($bookingId);
            if ($checkIn) {
                ResponseHandler::setResponse('Checkin berhasil');
                header('location:' . URL . '/admin/booking/index');
            } else {
                ResponseHandler::setResponse('Gagal checkin');
                header('location:' . URL . '/admin/booking/index');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/booking/index');
        }
    }

    public function check_out($bookingId)
    {
        try {
            $checkOut = BookingLog::checkOut($bookingId);
            if ($checkOut) {
                ResponseHandler::setResponse('Checkout berhasil');
                header('location:' . URL . '/admin/booking/index');
            } else {
                ResponseHandler::setResponse('Gagal checkout');
                header('location:' . URL . '/admin/booking/index');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/booking/index');
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
