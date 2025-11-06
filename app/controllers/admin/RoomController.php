<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Utils\Validator;
use App\Error\CustomException;
use App\Core\ResponseHandler;
use App\Models\Room;
class RoomController extends Controller {
    private $room;

    public function __construct()
    {
        $this->room = $this->model('room'); 
    }

    public function index()
    {
        $data = $this->room->get();
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
            if($errors) throw new CustomException($validator->getErrors());

            if($data['min'] > $data['max']) throw new CustomException('Kapasitas minimal harus lebih kecil dari kapasitas maximal'); 

            $file = $data['image']['tmp_name'];
            $allowedMimes = ["image/jpeg", "image/png", "image/jpg"];
            $getFileInfo = getimagesize($file);
            if (!in_array($getFileInfo['mime'], $allowedMimes)) {
                throw new CustomException(['image' => "File tidak didukung"]);
            }

            $newPath = "storage/rooms/" . $data['image']['name'];
            move_uploaded_file($data['image']['tmp_name'], dirname(__DIR__) . '/../public/' . $newPath);
            $data['image'] = $newPath;
            
            $insert = Room::create($data);
            if($insert) {
                ResponseHandler::setResponse("Berhail memasukan data ruangan");
                header('location:' . URL . '/admin/room/index');
            } else {
                throw new CustomException('Gagal memasukan data');
            }

        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/admin/room/create');
        }
    }

    public function detail($id) 
    {
        try {
            $data = Room::getById($id);
            if(!$data) {
                throw new CustomException('Data ruangan tidak ditemukan');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages());
            header('location:' . URL . '/admin/room/index');
        }
    }

    public function edit($id)
    {
        try {
            $data = Room::getById($id);
            if(!$data) {
                throw new CustomException('Data ruangan tidak ditemukan');
            }
            $this->view('admin/rooms/edit', $data, layoutType: "Admin");
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL. '/room/index');
        }
    }

    public function update($id) 
    {
        try {
            $data = [
                "name" => $_POST['name'],
                "floor" => (int) $_POST['floor'],
                "min" => (int) $_POST['min'],  
                "max" => (int) $_POST['max'],
                "description" => $_POST['description'],
                "isSpecial" => isset($_POST['isSpecial']) ? 1 : 0,
                "isOperational" => isset($_POST['isOperational']) ? 1 : 0,
                "image" => empty($_FILES['file_upload']['name']) ? null : $_FILES['file_upload']
            ];

            $validator = new Validator($data);
            $validator->field("name", ['required']);
            $validator->field("floor", ['required'], 'int');
            $validator->field("min", ['required'], 'int');
            $validator->field("max", ['required'], '');

            $errors = $validator->error();
            if($errors) throw new CustomException($validator->getErrors());

            if($data['min'] > $data['max']) throw new CustomException('Kapasitas minimal harus lebih kecil dari kapasitas maximal'); 

            if($data['image'] === null) {
                unset($data['image']);
            } else {
                $file = $data['image']['tmp_name'];
                $allowedMimes = ["image/jpeg", "image/png", "image/jpg"];
                $getFileInfo = getimagesize($file);
                if (!in_array($getFileInfo['mime'], $allowedMimes)) {
                    throw new CustomException(['image' => "File tidak didukung"]);
                }
                $newPath = "storage/rooms/" . $data['image']['name'];
                move_uploaded_file($data['image']['tmp_name'], dirname(__DIR__) . '/../../public/' . $newPath);
                $data['image'] = $newPath;
            }

            $update = Room::update($id, $data);
            if($update) {
                ResponseHandler::setResponse("Berhasil memperbarui data ruangan");
                header('location:' . URL . '/admin/room/index');
            } else {
                throw new CustomException('Gagal memperbarui data ruangan');
            }

        } catch(CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            $error = ResponseHandler::getResponse();
            var_dump($error);
            die;
            header('location:' . URL . '/admin/room/edit/' . $id);
        }

    }

    public function delete($id)
    {
        try {
            $delete = Room::softDelete($id); 
            if($delete) {
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
} 