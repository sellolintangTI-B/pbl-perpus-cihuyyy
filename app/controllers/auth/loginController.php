<?php

namespace App\Controllers\Auth;

use App\Core\Controller;
use App\Utils\Validator;
use App\Error\CustomException;
use App\Core\ResponseHandler;
use App\Models\User;
use App\Utils\Authentication;

class LoginController extends Controller
{
    private $user;

    public function __construct()
    {
        $auth = new Authentication;

        if (!empty($auth->user)) {
            if ($auth->user['role'] === 'Admin') {
                header('location:' . URL . '/admin/dashboard/index');
            } elseif ($auth->user['role'] === 'Mahasiswa' || $auth->user['role'] === 'Dosen') {
                header('location:' . URL . '/user/room/index');
            }
        }
    }

    public function index()
    {
        $this->view('auth/login', layoutType: $this::$layoutType["default"]);
    }

    public function signIn()
    {
        try {
            $data = [
                "identifier" => $_POST['username'],
                "password" => $_POST['password'],
                "captcha" => $_POST['captcha']
            ];
            $validator = new Validator($data);
            str_contains($data['identifier'], '@') ? $validator->field("identifier", ['required', 'email']) : $validator->field('identifier', ['required']);
            $validator->field("password", ["required"]);
            $validator->field('captcha', ['required']);
            $errors = $validator->error();
            if ($errors) throw new CustomException($validator->getErrors());

            // if($_SESSION['captcha'] !== $data['captcha']) throw new CustomException('Captcha tidak valid');

            $checkIfUserExist = User::getByEmailOrIdNumber($data['identifier']);
            if (!$checkIfUserExist) throw new CustomException('Credentials not match');
            if (!password_verify($data['password'], $checkIfUserExist['password_hash'])) throw new CustomException('Credentials not match');
            if (!$checkIfUserExist['is_active']) throw new CustomException('Akun ini masih menunggu verifikasi admin');

            if (isset($_POST['remember_me'])) {
                setcookie('remember_username', $_POST['username'], time() + (30 * 24 * 60 * 60), '/');
            } else {
                $paths = ['/', '/auth', '/auth/login', '/auth/login/index'];
                foreach ($paths as $p) {
                    setcookie('remember_username', '', time() - 3600, $p);
                }
                unset($_COOKIE['remember_username']);
            }


            $_SESSION['loggedInUser'] = [
                "username" => $checkIfUserExist['first_name'] . ' ' . $checkIfUserExist['last_name'],
                "role" => $checkIfUserExist['role'],
                "id_number" => $checkIfUserExist['id_number'],
                "email" => $checkIfUserExist['email'],
                "id" => $checkIfUserExist['id'],
                "img_url" => $checkIfUserExist['profile_picture_url'],
            ];

            if ($checkIfUserExist['role'] === 'Admin') {
                header('location:' . URL . '/admin/dashboard/index');
            } elseif ($checkIfUserExist['role'] === 'Mahasiswa' || $checkIfUserExist['role'] === 'Dosen') {
                header('location:' . URL . '/user/room/index');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/auth/login/index');
        }
    }
}
