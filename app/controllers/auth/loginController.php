<?php

namespace App\Controllers\Auth;

use App\Core\Controller;
use App\Utils\Validator;
use App\Error\CustomException;
use App\Core\ResponseHandler;
use App\Models\User;
use App\Utils\Authentication;
use Carbon\Carbon;

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
                "captcha" => $_POST['cf-turnstile-response']
            ];

            $validator = new Validator($data);
            str_contains($data['identifier'], '@') ? $validator->field("identifier", ['required', 'email']) : $validator->field('identifier', ['required']);
            $validator->field("password", ["required"]);
            $validator->field("captcha", ['captcha']);

            $errors = $validator->error();
            if ($errors) throw new CustomException($validator->getErrors());

            $checkIfUserExist = User::getByEmailOrIdNumber($data['identifier']);
            if (!$checkIfUserExist) throw new CustomException('NIM/NIP/EMAIL Belum terdaftar');
            if(Carbon::parse($checkIfUserExist['active_periode'])->lte(Carbon::now('Asia/Jakarta'))) throw new CustomException('Akun anda sudah melewati masa aktif');
            if (!password_verify($data['password'], $checkIfUserExist['password_hash'])) throw new CustomException('Credentials not match');
            if (!$checkIfUserExist['is_active']) throw new CustomException('Akun ini masih menunggu verifikasi admin');

            $validateTurnStileBody = [
                'secret' => $_ENV['TURNSTILE_SECRETKEY'],
                'response' => $data['captcha'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];

            $validateCaptcha = $this->validateCaptcha($validateTurnStileBody);
            if (!$validateCaptcha) throw new CustomException('Gagal verifikasi captcha');

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
                "username" => $checkIfUserExist['first_name'],
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
