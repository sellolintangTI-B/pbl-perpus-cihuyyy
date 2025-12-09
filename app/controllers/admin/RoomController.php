<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Utils\Validator;
use App\Error\CustomException;
use App\Core\ResponseHandler;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Utils\Authentication;
use App\Utils\FileHandler;
use App\Utils\Mailer;
use Carbon\Carbon;

class RoomController extends Controller
{

    public function index()
    {
        $params = [];
        $page = 0;
        if (isset($_GET['status']) && !empty($_GET['status'])) $params['is_operational'] = $_GET['status'];

        if (isset($_GET['isSpecial']) && !empty($_GET['isSpecial'])) $params['requires_special_approval'] = $_GET['isSpecial'];

        if (isset($_GET['floor']) && !empty($_GET['floor'])) $params['floor'] = $_GET['floor'];

        if (isset($_GET['search']) && !empty($_GET['search'])) $params['name'] = $_GET['search'];

        if (isset($_GET['page'])) $page = (int)$_GET['page'] - 1;

        $rooms = Room::getALl($params, $page);
        $count = Room::count($params);
        $data = [
            'rooms' => $rooms,
            'total_page' => ceil((int)$count->count / 5)
        ];

        $this->view('admin/rooms/index', $data, layoutType: "Admin");
    }

    public function create()
    {
        $this->view('admin/rooms/create', layoutType: "Admin");
    }

    public function store()
    {
        try {
            $data = [
                "name" => $_POST['name'],
                "floor" => (int) $_POST['floor'],
                "min" => (int) $_POST['min'],
                "max" => (int) $_POST['max'],
                "description" => $_POST['description'],
                "isSpecial" => isset($_POST['isSpecial']) ? 1 : 0,
                "image" => empty($_FILES['image']['name']) ? null : $_FILES['image']
            ];

            $validator = new Validator($data);
            $validator->field('name', ['required']);
            $validator->field('floor', ['required', 'int']);
            $validator->field('min', ['required', 'int']);
            $validator->field('max', ['required', 'int']);
            $validator->field('description', ['required']);
            $validator->field('image', ['required']);

            $errors = $validator->error();
            if ($errors) throw new CustomException($validator->getErrors());

            if ($data['floor'] <= 0 || $data['min'] <= 0 || $data['max'] <= 0) throw new CustomException('Tidak Boleh dibawah 0 atau 0');

            if ($data['min'] > $data['max']) throw new CustomException('Kapasitas minimal harus lebih kecil dari kapasitas maximal');

            $file = $data['image']['tmp_name'];
            $allowedMimes = ["image/jpeg", "image/png", "image/jpg"];
            $getFileInfo = getimagesize($file);
            if (!in_array($getFileInfo['mime'], $allowedMimes)) {
                throw new CustomException(['image' => "File tidak didukung"]);
            }

            $newPath = "storage/rooms/" . $data['image']['name'];
            move_uploaded_file($data['image']['tmp_name'], dirname(__DIR__) . '/../../public/' . $newPath);
            $data['image'] = $newPath;

            $insert = Room::create($data);
            if ($insert) {
                ResponseHandler::setResponse("Berhail memasukan data ruangan");
                $_SESSION['old_rooms'] = [];
                header('location:' . URL . '/admin/room/index');
            } else {
                throw new CustomException('Gagal memasukan data');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            $this->redirectWithOldInput(url: '/admin/room/create', oldData: $_POST, session_name: 'old_rooms');
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
            return $this->view('admin/rooms/detail', $data, layoutType: $this::$layoutType['admin']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages());
            header('location:' . URL . '/admin/room/index');
        }
    }

    public function edit($id)
    {
        try {
            $data = Room::getById($id);
            if (!$data) {
                throw new CustomException('Data ruangan tidak ditemukan');
            }
            $this->view('admin/rooms/edit', $data, layoutType: "Admin");
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/room/index');
        }
    }

    public function update($id)
    {
        try {
            $data = [
                "name" => $_POST['name'],
                "floor" => (int) $_POST['floor'],
                "min_capacity" => (int) $_POST['min'],
                "max_capacity" => (int) $_POST['max'],
                "description" => $_POST['description'],
                "requires_special_approval" => $_POST['isSpecial'],
                "is_operational" => $_POST['isOperational'],
                "room_img_url" => empty($_FILES['file_upload']['name']) ? null : $_FILES['file_upload']
            ];

            $validator = new Validator($data);
            $validator->field("name", ['required']);
            $validator->field("floor", ['required'], 'int');
            $validator->field("min_capacity", ['required'], 'int');
            $validator->field("max_capacity", ['required'], '');

            $errors = $validator->error();
            if ($errors) throw new CustomException($validator->getErrors());

            if ($data['min_capacity'] > $data['max_capacity']) throw new CustomException('Kapasitas minimal harus lebih kecil dari kapasitas maximal');

            if ($data['room_img_url'] === null) {
                unset($data['room_img_url']);
            } else {
                $file = $data['room_img_url']['tmp_name'];
                $allowedMimes = ["image/jpeg", "image/png", "image/jpg"];
                $getFileInfo = getimagesize($file);
                if (!in_array($getFileInfo['mime'], $allowedMimes)) {
                    throw new CustomException(['image' => "File tidak didukung"]);
                }
                $path = FileHandler::save($data['room_img_url'], 'rooms');
                $data['room_img_url'] = $path;
            }

            $update = Room::update($id, $data);
            if ($update) {
                ResponseHandler::setResponse("Berhasil memperbarui data ruangan");
                header('location:' . URL . '/admin/room/index');
            } else {
                throw new CustomException('Gagal memperbarui data ruangan');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/admin/room/edit/' . $id);
        }
    }

    public function delete($id)
    {
        try {
            $authUser = new Authentication;
            $delete = Room::softDelete($id, $authUser->user['id']);
            if ($delete) {
                foreach ($delete as $data) {
                    $user = User::getById($data->affected_user_id);
                    Mailer::send($user->email, 'PEMBERITAHUAN', 'Booking anda telah di cancel oleh admin');
                }
                ResponseHandler::setResponse("Berhasil menghapus data ruangan");
                header('location:' . URL . '/admin/room/index');
            } else {
                throw new CustomException('Gagal menghapus data ruangan');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/admin/room/index');
        }
    }

    public function deactivate($id)
    {
        try {
            $updateStatus = Room::update($id, [
                'is_operational' => 0
            ]);
            if ($updateStatus) {
                ResponseHandler::setResponse('Berhasil mengubah status ruangan');
                header('location:' . URL . '/admin/room/index');
            } else {
                throw new CustomException('Terjadi kesalahan');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/admin/room/index');
        }
    }
    public function activate($id)
    {
        try {
            $updateStatus = Room::update($id, [
                'is_operational' => 1
            ]);
            if ($updateStatus) {
                ResponseHandler::setResponse('Berhasil mengubah status ruangan');
                header('location:' . URL . '/admin/room/index');
            } else {
                throw new CustomException('Terjadi kesalahan');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/admin/room/index');
        }
    }
}
