<?php

namespace App\Controllers\Auth;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Models\User;
use App\Utils\Authentication;
use App\Utils\Captcha;
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
    }

    public function index()
    {
        $captchaCode = Captcha::Generate();
        $this->view('auth/register', $captchaCode, layoutType: $this::$layoutType["default"]);
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
                "image" => empty($_FILES['file_upload']['name']) ? null : $_FILES['file_upload'],
                "captcha" => $_POST['captcha']
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
            $validator->field("captcha", ['required']);

            $errors = $validator->error();
            if ($errors) throw new CustomException($validator->getErrors());
            
            if($_SESSION['captcha'] !== $data['captcha']) throw new CustomException('Captcha tidak valid');

            $checkByIdNumber = User::getByIdNumber($data['id_number']);
            $checkByEmail = User::getByEmail($data['email']);

            if($checkByIdNumber) throw new CustomException('NIM / NIP sudah terdaftar');
            if($checkByEmail) throw new CustomException('Email sudah terdaftar');

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
            $insertData = User::insert($data);
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
