<?php

namespace App\Controllers\user;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\BookingParticipant;
use App\Models\Room;
use App\Models\Suspension;
use App\Models\User;
use App\Utils\Authentication;
use App\Utils\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{

    public function index()
    {
        try {
            $user = new Authentication;
            $params = 'berlangsung';
            $status = 'semua';
            if (isset($_GET['tab'])) $params = $_GET['tab'];
            if (isset($_GET['status'])) $status = $_GET['status'];
            if ($params == 'berlangsung') {
                $data = Booking::checkUserActiveBooking($user->user['id']);
            } elseif ($params = 'riwayat') {
                $data = Booking::getUserBookingHistory($user->user['id']);
            }

            $this->view('user/booking/index', $data, layoutType: "Civitas");
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/user/booking/index');
        }
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
                "list_anggota" => json_decode($_POST['list_anggota'], true)
            ];

            $validator = new Validator($data);
            $validator->field('datetime', ['required']);
            $validator->field('duration', ['required']);
            if ($validator->error()) throw new CustomException($validator->getErrors());

            $start = Carbon::parse($data['datetime']);
            $end = Carbon::parse($data['duration'])->setDateFrom($start);
            $data['datetime'] = $start->toDateTimeString();
            $data['duration'] = $start->diffInMinutes($end);
            $data['end_time'] = $start->copy()->addMinutes($start->diffInMinutes($end))->toDateTimeString();

            $rules = $this->validationBookingRules($id, $data, $data['user_id']);
            if (!$rules['status']) throw new CustomException($rules['message']);

            $members = $data['list_anggota'];
            $data['booking_code'] = $this->generateBookingCode();
            unset($data['list_anggota']);

            $booking = Booking::create($data);
            $members = $this->addBookingIdToMembersData($members, $booking->id);
            $bookingLog = BookingLog::create($booking->id);
            $bookingParticipants = BookingParticipant::bulkInsert($members);

            ResponseHandler::setResponse("Berhasil menambahkan data");
            header("location:" . URL . '/user/room/index');
            $_SESSION['old_input'] = null;
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            $this->redirectWithOldInput(url: '/user/room/detail/' . $id, oldData: $_POST);
        }
    }

    private function validationBookingRules($roomId, $data, $userId)
    {
        try {
            $checkIsUserSupended = User::checkUserSuspend($userId);
            if ($checkIsUserSupended->is_suspend) {
                throw new CustomException("Anda sedang dalam masa suspension. Tidak bisa meminjam ruangan sampai " . $checkIsUserSupended->suspend_date);
            }
            $checkUserActiveBooking = Booking::checkUserActiveBooking($userId);
            if ($checkUserActiveBooking) throw new CustomException('Tolong selesaikan peminjaman anda terlebih dahulu sebelum meminjam ruangan lain');
            $roomDetail = Room::getById($roomId);
            if (Carbon::parse($data['datetime'])->lt(Carbon::now('Asia/Jakarta'))) throw new CustomException('Tidak bisa booking di kemarin hari');

            if (Carbon::today('Asia/Jakarta')->diffInDays($data['datetime']) >= 7) throw new CustomException('Tidak bisa booking untuk jadwal lebih dari 7 hari per hari ini');

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

    private function addBookingIdToMembersData($members, $bookingId)
    {
        $members = array_map(function ($item) use ($bookingId) {
            $item['booking_id'] = $bookingId;
            return $item;
        }, $members);
        return $members;
    }

    public function detail($id)
    {
        try {
            $booking = Booking::getById($id);
            if (!$booking) throw new CustomException('Data tidak ditemukan');
            $bookingParticipants = BookingParticipant::getParticipantsByBookingId($id);
            $data  = [
                "booking" => $booking,
                "participants" => $bookingParticipants
            ];
            $this->view('user/booking/detail', $data, layoutType: $this::$layoutType['civitas']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages());
            header('location:' . URL . '/user/booking/index');
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

    public function cancel_booking($id)
    {
        try {
            $user = new Authentication;
            $data = [
                'user_id' => $user->user['id'],
                'booking_id' => $id,
                'reason' => 'saya malas'
            ];
            $bookingCheck = Booking::getById($data['booking_id']);
            if (!$bookingCheck) throw new CustomException('Booking tidak tersedia');
            if ($bookingCheck->pic_id !== $data['user_id']) throw new CustomException('Maaf anda bukan PIC dari peminjaman ini');
            $checkSuspendUser = Suspension::checkSupensionsByUserId($data['user_id']);
            if (!$checkSuspendUser) {
                $suspension = Suspension::create([
                    'user_id' => $data['user_id'],
                    'point' => 1
                ]);
            } else {
                $suspension = Suspension::update([
                    'id' => $checkSuspendUser->id,
                    'point' => $checkSuspendUser->suspend_count + 1
                ]);
            }

            $cancelled = BookingLog::cancel($data);
            $responseMessage = 'Berhasil membatalkan peminjaman';
            if ($suspension->suspend_count >= 3) {
                $suspendUser = User::suspendAccount($data['user_id']);
                $suspendDate = Carbon::parse($suspendUser->suspend_untill)->toDateString();
                $responseMessage = "Berhasil membatalkan peminjaman dan akun anda akan tersuspend sampai $suspendDate karna sudah 3 kali melakukan pembatalan peminjaman";
            }

            if ($cancelled) {
                ResponseHandler::setResponse($responseMessage);
                header('location:' . URL . '/user/room/index');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/user/room/index');
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
}
