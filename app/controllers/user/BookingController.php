<?php

namespace App\Controllers\user;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\BookingParticipant;
use App\Models\Feedback;
use App\Models\LibraryClose;
use App\Models\Room;
use App\Models\Suspension;
use App\Models\User;
use App\Utils\Authentication;
use App\Utils\Mailer;
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
                $data = Booking::getUserBookingHistory($user->user['id'], $status);
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
                "user_id" => $user->user["id"],
                'room_id' => $id,
                "start_time" => $_POST['start_time'],
                'date' => $_POST['date'],
                "end_time" => $_POST['end_time'],
                "list_anggota" => json_decode($_POST['list_anggota'], true)
            ];

            $validator = new Validator($data);
            $validator->field('date', ['required']);
            $validator->field('start_time', ['required']);
            $validator->field('end_time', ['required']);
            if ($validator->error()) throw new CustomException($validator->getErrors());

            $start = Carbon::parse($data['date'])->setTimeFromTimeString($data['start_time']);
            $end = Carbon::parse($data['date'])->setTimeFromTimeString($data['end_time']);
            $data['date'] = $start;
            $data['duration'] = $start->diffInMinutes($end);
            $data['end_time'] = $end;

            $getRoomById = Room::getById($data['room_id']);
            if (!$getRoomById->is_operational) throw new CustomException('Ruangan sedang tidak beroperasi');

            $rules = $this->validationBookingRules($getRoomById, $data, $data['user_id']);
            if (!$rules['status']) throw new CustomException($rules['message']);

            $members = $data['list_anggota'];
            $data['booking_code'] = $this->generateBookingCode();

            $booking = Booking::create([
                'user_id' => $data['user_id'],
                'room_id' => $data['room_id'],
                'start_time' => $data['date']->toDateTimeString(),
                'duration' => $data['duration'],
                'end_time' => $data['end_time'],
                'booking_code' => $data['booking_code']
            ]);

            $members = $this->addBookingIdToMembersData($members, $booking->id);
            $bookingParticipants = BookingParticipant::bulkInsert($members);

            Mailer::send($user->user['email'], 'KODE BOOKING', $data['booking_code']);
            ResponseHandler::setResponse("Berhasil menambahkan data");
            header("location:" . URL . '/user/room/index');
            $_SESSION['old_booking'] = null;
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            $this->redirectWithOldInput(url: '/user/room/detail/' . $id, oldData: $_POST, session_name: 'old_booking');
        }
    }


    private function validationBookingRules($room, $data, $userId)
    {
        try {
            $readSchedule = file_get_contents(dirname(__DIR__) . '/../../schedule.json');
            $scheduleJson = json_decode($readSchedule, true);

            $checkIsUserSupended = User::checkUserSuspend($userId);
            if ($checkIsUserSupended->is_suspend) {
                throw new CustomException("Anda sedang dalam masa suspension. Tidak bisa meminjam ruangan sampai " . $checkIsUserSupended->suspend_date);
            }

            $checkUserActiveBooking = Booking::checkUserActiveBooking($userId);
            if ($checkUserActiveBooking) throw new CustomException('Tolong selesaikan peminjaman anda terlebih dahulu sebelum meminjam ruangan lain');

            $checkIfLibraryClose = LibraryClose::getByDate($data['date']->format('Y-m-d'));
            if ($checkIfLibraryClose) throw new CustomException('Tidak bisa booking di tanggal ini');

            if ($data['date']->isWeekend()) throw new CustomException('Tidak bisa booking di weekend');
            if ($data['date']->lt(Carbon::now('Asia/Jakarta'))) throw new CustomException('Tidak bisa booking di kemarin hari');
            if (Carbon::today('Asia/Jakarta')->diffInDays($data['date']) >= 7) throw new CustomException('Tidak bisa booking untuk jadwal lebih dari 7 hari per hari ini');

            if ($data['date']->isToday()) {
                $startHour = $data['date']->format('H:i:s');
                $nowHour = Carbon::now('Asia/Jakarta')->format('H:i:s');
                if ($startHour < $nowHour) throw new CustomException('Tidak bisa booking pada jam yang sudah lewat');
            }

            $dayCheck = $scheduleJson[$data['date']->dayOfWeek()];
            $isValid = false;
            foreach ($dayCheck as $slot) {
                $startSchedule = Carbon::parse($data['date'])->setTimeFromTimeString($slot["start"]);
                $endSchedule = Carbon::parse($data['date'])->setTimeFromTimeString($slot["end"]);
                if ($data['date']->gte($startSchedule) && $data['end_time']->lte($endSchedule)) {
                    $isValid = true;
                    break;
                }
            }
            if (!$isValid) throw new CustomException('Tidak bisa booking di waktu yang anda masukan, harap lihat jadwal perpustakaan');

            if ($data['duration'] < 60) throw new CustomException('Minimal durasi pinjam ruangan 1 jam');
            if ($data['duration'] > 180) throw new CustomException('Maximal durasi pinjam ruangan 3 jam');

            $checkIfScheduleExists = Booking::checkSchedule($data['date']->toDateTimeString(), $data['duration'], $room->id);
            if ($checkIfScheduleExists) throw new CustomException('Jadwal sudah dibooking');

            if (count($data['list_anggota']) < $room->min_capacity) throw new CustomException("Minimal kapasitas adalah $room->min_capacity orang");
            if (count($data['list_anggota']) > $room->max_capacity) throw new CustomException("Maximal kapasitas adalah $room->max_capacity orang");

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
            $authUser = new Authentication;
            $booking = Booking::getById($id);
            if (!$booking) throw new CustomException('Data tidak ditemukan');
            $bookingParticipants = BookingParticipant::getParticipantsByBookingId($id);
            $feedback = Feedback::getByBookingIdAndUserId($id, $authUser->user['id']);

            if ($booking->current_status == 'cancelled') {
                $detailCancel = BookingLog::getCancelDetailByBookingId($id);
            }
            if ($booking->current_status == 'finished') {
                $detailFinished = BookingLog::getFinishedDetailByBookingId($id);
            }
            $data  = [
                "booking" => $booking,
                "participants" => $bookingParticipants,
                "feedback" => $feedback,
                'detailCancel' => $detailCancel[0] ?? null,
                'detailFinished' => $detailFinished ?? null,
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
                'reason' => $_POST['reason']
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

    public function send_feedback($id)
    {
        try {
            $authUser = new Authentication;
            $data = [
                'rating' => $_POST['rating'],
                'feedback' => $_POST['feedback'],
                'booking_id' => $id,
                'user_id' => $authUser->user['id']
            ];

            $validator = new Validator($data);
            $validator->field('feedback', ['required']);
            if ($validator->error()) throw new CustomException($validator->getErrors());

            $feedback = Feedback::create($data);
            if ($feedback) {
                ResponseHandler::setResponse('Terima kasih sudah memberikan feedback anda');
                header('location:' . URL . '/user/booking/index?tab=riwayat');
            } else {
                ResponseHandler::setResponse('Gagal memberikan feedback');
                header('location:' . URL . "/user/booking/detail/$id");
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:');
        }
    }
}
