<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Utils\Authentication;
use App\Utils\Validator;
use App\Error\CustomException;
use App\Core\ResponseHandler;

class AuthController extends Controller
{
    private $user;

    public function __construct()
    {
        $auth = new Authentication;

        if(!empty($auth->user)) {
            if($auth->user['role'] === 'Admin') {
                header('location:'. URL . '/admin/index');
            } elseif($auth->user['role'] === 'Mahasiswa' || $auth->user['role'] === 'Dosen') {
                header('location:' . URL . '/user/index');
            }
        }
        $this->user = $this->model('user');
    }

    public function register()
    {
        $this->view('auth/register', layoutType: $this::$layoutType["default"]);
    }

    public function login(){
        $this->view('auth/login', layoutType: $this::$layoutType["default"]);
    }

    public function signup()
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
                "image" => $_FILES
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
                header('location:'. URL . '/auth/register');
            }

        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/auth/register');
        }
    }

    public function signIn()
    {
        try {

            $data = [
                "identifier" => $_POST['username'],
                "password" => $_POST['password']
            ];

            $validator = new Validator($data);
            str_contains($data['identifier'], '@') ? $validator->field("identifier", ['required', 'email']) : $validator->field('identifier', ['required']);
            $validator->field("password", ["required"]);
            $errors = $validator->error();

            if ($errors) {
                var_dump($validator->getErrors());
                throw new CustomException($validator->getErrors());
            }

            $checkIfUserExist = $this->user->getByEmailOrIdNumber($data['identifier']);
            if(!$checkIfUserExist) throw new CustomException('Credentials not match');
            if(!password_verify($data['password'], $checkIfUserExist['password_hash'])) throw new CustomException('Credentials not match');
            if(!$checkIfUserExist['is_active']) throw new CustomException('Akun ini masih menunggu verifikasi admin');

            $_SESSION['loggedInUser'] = [
                "username" => $checkIfUserExist['first_name'] . ' ' . $checkIfUserExist['last_name'],
                "role" => $checkIfUserExist['role'],
                "id_number" => $checkIfUserExist['id_number'],
                "email" => $checkIfUserExist['email'],
                "id" => $checkIfUserExist['id']
            ];

            if($checkIfUserExist['role'] === 'Admin') {
                header('location:' . URL . '/admin/index');
            } elseif ($checkIfUserExist['role'] === 'Mahasiswa' || $checkIfUserExist['role'] === 'Dosen') {
                header('location:' . URL . '/user/index');
            } 

        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/auth/login');
        }
    }

    public function logout()
    {
        $auth = new Authentication;
        if($auth->logout()) {
            header('location:' . URL . '/auth/login');
        }
    }
}
