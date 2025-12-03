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
        $this->view('auth/register', layoutType: $this::$layoutType["default"]);
    }

    public function signUp()
    {
        try {
            $data = [
                "id_number" => $_POST['id_number'],
                "email" => $_POST['email'],
                "password_hash" => $_POST['password'],
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'] ?? "",
                "institution" => "Politeknik Negeri Jakarta",
                "study_program" => $_POST['prodi'],
                "phone_number" => $_POST['phone_number'],
                "role" => $_POST['role'],
                "image" => empty($_FILES['file_upload']['name']) ? null : $_FILES['file_upload'],
                "captcha" => $_POST['cf-turnstile-response'],
                "major" => $_POST['jurusan']
            ];

            $validator = new Validator($data);
            $validator->field("id_number", ["required"]);
            $validator->field("email", ["required", "email"]);
            $validator->field("password_hash", ["required", "password"]);
            $validator->field("first_name", ["required"]);
            $validator->field("institution", ["required"]);
            $validator->field("study_program", ["required"]);
            $validator->field("phone_number", ["required"]);
            $validator->field("role", ["required"]);
            $validator->field("image", ["required"]);
            $validator->field("captcha", ['captcha']);

            $errors = $validator->error();
            if ($errors) throw new CustomException($validator->getErrors());


            $validateTurnStileBody = [
                'secret' => $_ENV['TURNSTILE_SECRETKEY'],
                'response' => $data['captcha'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];

            $validateCaptcha = $this->validateCaptcha($validateTurnStileBody);
            if(!$validateCaptcha) throw new CustomException('Gagal verifikasi captcha');

            $checkByIdNumber = User::getByUniqueField(id_number: $data['id_number']);
            $checkByEmail = User::getByUniqueField(email: $data['email']);
            $checkByPhoneNumber = User::getByUniqueField(phoneNumber: $data['phone_number']);

            if ($checkByIdNumber) throw new CustomException('NIM / NIP sudah terdaftar');
            if ($checkByEmail) throw new CustomException('Email sudah terdaftar');
            if ($checkByPhoneNumber) throw new CustomException('Nomor Telfon sudah terdaftar');

            $file = $_FILES['file_upload']['tmp_name'];
            $allowedMimes = ["image/jpeg", "image/png", "image/jpg"];
            $getFileInfo = getimagesize($file);
            if (!in_array($getFileInfo['mime'], $allowedMimes)) {
                throw new CustomException(['image' => "File tidak didukung"]);
            }

            $newPath = 'storage/users/' . $_FILES['file_upload']['name'];
            move_uploaded_file($file, dirname(__DIR__) . "/../../public/" . $newPath);
            $data['activation_proof_url'] = $newPath;
            $data['password_hash'] = password_hash($data['password_hash'], PASSWORD_BCRYPT);

            $insertData = User::insert([
                'id_number' => $data['id_number'],
                'email' => $data['email'],
                'password_hash' => $data['password_hash'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'institution' => $data['institution'],
                'major' => $data['major'],
                'study_program' => $data['study_program'],
                'phone_number' => $data['phone_number'],
                'role' => $data['role'],
                'activation_proof_url' => $data['activation_proof_url']
            ]);

            if ($insertData) {
                ResponseHandler::setResponse("Registrasi berhasil, tunggu verifikasi admin");
                header('location:' . URL . '/auth/login/index');
                $_SESSION['register_old'] = null;
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            $this->redirectWithOldInput('/auth/register/index', $data, 'register_old');
        }
    }

    private function validateCaptcha($body)
    {
        $url = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($body)
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $response = json_decode($result);
        if ($response->success) {
            return true;
        } else {
            return false;
        }
    }
}
