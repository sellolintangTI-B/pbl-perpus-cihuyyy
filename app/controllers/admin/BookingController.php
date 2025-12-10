<?php

namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\BookingParticipant;
use App\Models\LibraryClose;
use App\Models\Room;
use App\Models\User;
use App\Utils\Authentication;
use App\Utils\FileHandler;
use App\Utils\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $params = [];
            $page = 0;

            if (isset($_GET['search']) && !empty($_GET['search'])) $params['booking_code'] = $_GET['search'];

            if (isset($_GET['room']) && !empty($_GET['room'])) $params['room_id'] = $_GET['room'];

            if (isset($_GET['status']) && !empty($_GET['status'])) $params['current_status'] = $_GET['status'];

            if (isset($_GET['tahun']) && !empty($_GET['tahun'])) $params['start_time'] = $_GET['tahun'];

            if (isset($_GET['bulan']) && !empty($_GET['bulan'])) $params['start_time'] = Carbon::create($_GET['tahun'], $_GET['bulan'])->format('Y-m');

            if (isset($_GET['date']) && !empty($_GET['date'])) $params['start_time'] = Carbon::create($_GET['tahun'], $_GET['bulan'], $_GET['date'])->format('Y-m-d');

            if (isset($_GET['page']) && !empty($_GET['page'])) $page = $_GET['page'] - 1;

            $room = Room::get();

            $booking = Booking::get($params, $page);

            $count = Booking::count($params);

            $data = [
                'room' => $room,
                'booking'  => $booking,
                'total_pages' => ceil((int) $count->count / 15)
            ];
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

    public function edit($id)
    {
        try {
            $booking = Booking::getById($id);
            if (in_array($booking->status, ['checked_in', 'finished', 'cancelled'])) throw new CustomException('Data tidak bisa diedit');
            if (!$booking) throw new CustomException('Data tidak ditemukan');
            $bookingParticipants = BookingParticipant::getParticipantsByBookingId($id);
            $roomDetail = Room::getById($booking->room_id);

            $data  = [
                "booking" => $booking,
                "participants" => $bookingParticipants,
                'roomList' => [],
                'roomDetail' => $roomDetail
            ];
            $data['roomList'] = Room::get();
            $this->view('admin/booking/edit', $data, layoutType: $this::$layoutType['admin']);
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
                if (!empty($_GET['date'])) {
                    if (empty($_GET['start_time'])) throw new CustomException('Harap masukan waktu mulai nya');
                    if (empty($_GET['end_time'])) throw new CustomException('Harap masukan waktu selesai nya');
                    $start = Carbon::parse($_GET['date']);
                    $params['start_time'] = $start->setTimeFromTimeString($_GET['start_time'])->toDateTimeString();
                    $duration = $start->setTimeFromTimeString($_GET['end_time']);
                    $params['duration'] = Carbon::parse($params['start_time'])->diffInMinutes($duration);
                }
            }

            if (isset($_GET['room'])) {
                $params['room'] = $_GET['room'];
            }

            if (isset($_GET['state']) && $_GET['state'] == 'detail' && isset($_GET['id'])) {
                $date = Carbon::now('Asia/Jakarta')->toDateString();
                if (isset($_GET['date_check'])) {
                    $date = Carbon::parse($_GET['date_check'])->toDateString();
                }
                $data['schedule'] = Booking::getByRoomId($_GET['id'], $date);
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

    public function store($id)
    {
        try {
            $data = [
                "room_id" => $id,
                "start_time" => $_POST['start_time'],
                "datetime" => $_POST['datetime'],
                "end_time" => $_POST['end_time'],
                "list_anggota" => isset($_POST['list_anggota']) ? json_decode($_POST['list_anggota'], true) : "",
                "file" => $_FILES['file'] ?? null
            ];

            $validator = new Validator($data);
            $validator->field('start_time', ['required']);
            $validator->field('datetime', ['required']);
            $validator->field('end_time', ['required']);
            if ($validator->error()) throw new CustomException($validator->getErrors());

            $start = Carbon::parse($data['datetime'])->setTimeFromTimeString($data['start_time']);
            $end = Carbon::parse($data['datetime'])->setTimeFromTimeString($data['end_time']);
            $data['datetime'] = $start;
            $data['duration'] = $start->diffInMinutes($end);
            $data['end_time'] = $end;

            $getRoomById = Room::getById($data['room_id']);
            if (!$getRoomById->is_operational) throw new CustomException('Ruangan sedang tidak beroperasi');

            $checkIfLibraryClose = LibraryClose::getByDate($data['datetime']->format('Y-m-d'));
            if ($checkIfLibraryClose) throw new CustomException('Tidak bisa booking di tanggal ini');

            $rules = $this->validationBookingRules($getRoomById, $data);
            if (!$rules['status']) throw new CustomException($rules['message']);

            $insertData = [
                'user_id' => $data['list_anggota'][0]['id'] ?? "",
                'room_id' => $data['room_id'],
                'start_time' => $data['datetime']->toDateTimeString(),
                'duration' => $data['duration'],
                'end_time' => $data['end_time']->toDateTimeString(),
                'booking_code' => $this->generateBookingCode()
            ];

            if ($getRoomById->requires_special_approval) {
                $path = FileHandler::save($data['file'], 'booking');
                $insertData['special_requirement_attachments_url'] = $path;
                unset($insertData['user_id']);
            }

            $booking = Booking::create($insertData);

            if (!empty($data['list_anggota'])) {
                $members = $data['list_anggota'];
                $members = $this->addBookingIdToMembersData($members, $booking->id);
                $bookingParticipants = BookingParticipant::bulkInsert($members);
            }

            ResponseHandler::setResponse("Berhasil menambahkan data");
            $_SESSION['old_booking'] = null;
            header("location:" . URL . '/admin/booking/index');
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            $this->redirectWithOldInput(url: "/admin/booking/create?state=detail&id=$id", oldData: $data, session_name: 'old_booking');
        }
    }

    public function update($id)
    {
        try {
            $data = [
                'booking_id' => $id,
                'room_id' => $_POST['room'],
                'datetime' => $_POST['datetime'],
                'start_time' => $_POST['start_time'],
                'end_time' => $_POST['end_time'],
                'list_anggota' => json_decode($_POST['list_anggota'], true)
            ];

            $validator = new Validator($data);
            $validator->field('datetime', ['required']);
            $validator->field('start_time', ['required']);
            $validator->field('end_time', ['required']);
            if ($validator->error()) throw new CustomException($validator->getErrors());

            $start = Carbon::parse($data['datetime'])->setTimeFromTimeString($data['start_time']);
            $end = Carbon::parse($data['datetime'])->setTimeFromTimeString($data['end_time']);
            $data['datetime'] = $start;
            $data['duration'] = $start->diffInMinutes($end);
            $data['end_time'] = $end;

            $getRoomById = Room::getById($data['room_id']);
            if (!$getRoomById->is_operational) throw new CustomException('Ruangan sedang tidak beroperasi');

            $rules = $this->validationBookingRules($getRoomById, $data);
            if (!$rules['status']) throw new CustomException($rules['message']);

            $members = $data['list_anggota'];
            $getParticipantsByBookingId = BookingParticipant::getUserIdByBookingId($id);

            $existsMembers = array_column($getParticipantsByBookingId, 'user_id');
            $requestedMemberIds = array_column($data['list_anggota'], 'id');

            $deletedMembers = array_values(array_diff($existsMembers, $requestedMemberIds));
            $addedMembers   = array_values(array_diff($requestedMemberIds, $existsMembers));

            if (!empty($deletedMembers)) {
                BookingParticipant::deleteParticipantsWhereInIds($id, $deletedMembers);
            }

            if (!empty($addedMembers)) {
                $formattingMembers = array_map(function ($userId) use ($id) {
                    return [
                        'id'    => $userId,
                        'booking_id' => $id
                    ];
                }, $addedMembers);
                $addParticipants = BookingParticipant::bulkInsert($formattingMembers);
            }

            $editedBook = Booking::edit($id, [
                'room_id' => $data['room_id'],
                'start_time' => $data['datetime']->toDateTimeString(),
                'duration' => $data['duration'],
                'end_time' => $data['end_time']->toDateTimeString(),
            ]);

            if ($editedBook) {
                ResponseHandler::setResponse('Berhasil mengubah data');
                header("location:" . URL . '/admin/booking/index');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . "/admin/booking/edit/$id");
        }
    }

    private function validationBookingRules($room, $data)
    {
        try {
            $readSchedule = file_get_contents(dirname(__DIR__) . '/../../schedule.json');
            $scheduleJson = json_decode($readSchedule, true);

            $checkIfLibraryClose = LibraryClose::getByDate($data['datetime']->format('Y-m-d'));
            if ($checkIfLibraryClose) throw new CustomException('Tidak bisa booking di tanggal ini');

            if ($data['datetime']->isWeekend()) throw new CustomException('Tidak bisa booking di weekend');
            if ($data['datetime']->lt(Carbon::now('Asia/Jakarta')->toDateString())) throw new CustomException('Tidak bisa booking di kemarin hari');
            if (Carbon::today('Asia/Jakarta')->diffInDays($data['datetime']) >= 7) throw new CustomException('Tidak bisa booking untuk jadwal lebih dari 7 hari per hari ini');

            $dayCheck = $scheduleJson[$data['datetime']->dayOfWeek()];
            $isValid = false;
            foreach ($dayCheck as $slot) {
                $startSchedule = Carbon::parse($data['datetime'])->setTimeFromTimeString($slot["start"]);
                $endSchedule = Carbon::parse($data['datetime'])->setTimeFromTimeString($slot["end"]);
                if ($data['datetime']->gte($startSchedule) && $data['end_time']->lte($endSchedule)) {
                    $isValid = true;
                    break;
                }
            }

            if ($data['datetime']->isToday()) {
                $startHour = $data['datetime']->format('H:i:s');
                $nowHour = Carbon::now('Asia/Jakarta')->format('H:i:s');
                if ($startHour < $nowHour) throw new CustomException('Tidak bisa booking pada jam yang sudah lewat');
            }
            if (!$isValid) throw new CustomException('Tidak bisa booking di waktu yang anda masukan, harap lihat jadwal perpustakaan');


            if ($data['duration'] < 60) throw new CustomException('Minimal durasi pinjam ruangan 1 jam');
            if ($data['duration'] > 180) throw new CustomException('Maximal durasi pinjam ruangan 3 jam');

            $checkIfScheduleExists = Booking::checkSchedule($data['datetime'], $data['duration'], $room->id);
            if ($checkIfScheduleExists) {
                if (isset($data['booking_id'])) {
                    if ($data['booking_id'] !== $checkIfScheduleExists->id) throw new CustomException('Jadwal sudah dibooking');
                } else {
                    throw new CustomException('Jadwal sudah dibooking');
                }
            }

            if (!empty($data['list_anggota'])) {
                if (count($data['list_anggota']) < $room->min_capacity) throw new CustomException("Minimal kapasitas adalah $room->min_capacity orang");
                if (count($data['list_anggota']) > $room->max_capacity) throw new CustomException("Maximal kapasitas adalah $room->max_capacity orang");
            }

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
