<?php

namespace App\Controllers;
use app\core\Controller;
use app\utils\Authentication;
use app\utils\Validator;
use app\error\CustomException;
use app\core\ResponseHandler;
use CurlShareHandle;

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
                "isSpecial" => isset($_POST['isSpecial']) ? 1 : 0,
                "image" => empty($_FILES['file_upload']['name']) ? null : $_FILES['file_upload'] 
            ];

            $validator = new Validator($data); 
            $validator->field('name', ['required']);
            $validator->field('floor', ['required', 'int']);
            $validator->field('min', ['required', 'int']);
            $validator->field('max', ['required', 'int']);
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
            
            $insert = $this->room->create($data);
            if($insert) {
                ResponseHandler::setResponse("Berhail memasukan data ruangan");
                header('location:' . URL . '/room/index');
            } else {
                throw new CustomException('Gagal memasukan data');
            }

        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/room/create');
        }
    }

    public function detail($id) 
    {
        $data = $this->room->getById($id);
    }

    public function edit($id)
    {

    }

    public function update($id) 
    {

    }

    public function delete($id)
    {
        
    }

} 