<?php

namespace App\Controllers\Auth;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Utils\Authentication;
use App\Utils\Validator;

class RegisterController extends Controller
{
    private $user;
    public function __construct()
    {
        $auth = new Authentication;

        if (!empty($auth->user)) {
            if ($auth->user['role'] === 'Admin') {
                header('location:' . URL . '/admin/index');
            } elseif ($auth->user['role'] === 'Mahasiswa' || $auth->user['role'] === 'Dosen') {
                header('location:' . URL . '/user/index');
            }
        }
        $this->user = $this->model('User');
    }

    public function index()
    {
        $this->view('auth/register', layoutType: $this::$layoutType["default"]);
    }

    public function signUp()
    {
        try {
            $data = [
                "id_number" => $_POST['id_number'],
                "email" => $_POST['email'],
                "password" => $_POST['password'],
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "institution" => "Politeknik Negeri Jakarta",
                "phone_number" => $_POST['phone_number'],
                "role" => $_POST['role'],
                "image" => empty($_FILES['file_upload']['name']) ? null : $_FILES['file_upload'] 
            ];

            $validator = new Validator($data);
            $validator->field("id_number", ["required"]);
            $validator->field("email", ["required", "email"]);
            $validator->field("password", ["required"]);
            $validator->field("first_name", ["required"]);
            $validator->field("last_name", ["required"]);
            $validator->field("institution", ["required"]);
            $validator->field("phone_number", ["required"]);
            $validator->field("role", ["required"]);
            $validator->field("image", ["required"]);

            $errors = $validator->error();
            if ($errors) {
                throw new CustomException($validator->getErrors());
            }

            $checkIfEmailExist = $this->user->getByEmail($data['email']);
            if ($checkIfEmailExist) {
                throw new CustomException(['email' => "Email sudah terdaftar"]);
            }

            $file = $_FILES['file_upload']['tmp_name'];
            $allowedMimes = ["image/jpeg", "image/png", "image/jpg"];
            $getFileInfo = getimagesize($file);
            if (!in_array($getFileInfo['mime'], $allowedMimes)) {
                throw new CustomException(['image' => "File tidak didukung"]);
            }

            $newPath = 'storage/users/' . $_FILES['file_upload']['name'];
            move_uploaded_file($file, __DIR__ . "/../../public/" . $newPath); 
            $data['image'] = $newPath;
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            $insertData = $this->user->insert($data);
            if($insertData) {
                ResponseHandler::setResponse("Registrasi berhasil, tunggu verifikasi admin");
                header('location:'. URL . '/auth/login/index');
            }

        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/auth/register/index');
        }
    }
}
