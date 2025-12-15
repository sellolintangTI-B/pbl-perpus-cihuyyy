<?php

namespace App\Controllers\Auth;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Models\ResetPassword;
use App\Models\User;
use App\Utils\Mailer;
use App\Utils\Validator;
use Carbon\Carbon;

class PasswordController extends Controller
{
    public function forget()
    {
        $this->view('auth/forget-password');
    }

    public function send_token()
    {
        try {
            $email = $_POST['email'];
            $user = User::getByEmail($email);
            if($user) {
                $bytes = random_bytes(32);
                $token = bin2hex($bytes);
                $url = URL . "/auth/password/new?token=$token";

                $storeToken = ResetPassword::store([
                    'email' => $email,
                    'token' => $token
                ]);

                if(!$storeToken) throw new CustomException("Terjadi kesalahan");

                Mailer::send($email, 'RESET PASSWORD', 'reset-password.php', [
                    'username' => $user['first_name'] . ' ' . $user['last_name'],
                    'url' => $url
                ]);
                header('location:' . URL . '/auth/password/successfully_sent');
            } else {
                header('location:' . URL . '/auth/password/successfully_sent');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/auth/login/index');
        }
    }

    public function successfully_sent()
    {
        $this->view('auth/successfully-sent');
    }

    public function new()
    {
        try {
            $token = $_GET['token'];
            $checkToken = ResetPassword::getToken($token);
            $tokenCreatedAt = Carbon::parse($checkToken->created_at);

            if(!$checkToken) throw new CustomException("Token tidak valid");
            if($checkToken->is_used) throw new CustomException('Token sudah expired');
            if (Carbon::now('Asia/Jakarta')->gt($tokenCreatedAt->copy()->addMinutes(60))) throw new CustomException('Token sudah expired');

            $this->view('auth/new-password', $token);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/auth/login/index');
        }
    }

    public function reset_password()
    {
        try {
            $data = [
                'password' => $_POST['password'],
                'password_confirmation' => $_POST['password_confirmation'],
                'token' => $_POST['token'],
            ];

            $v = new Validator($data);
            $v->field('password', ['required', 'password']);
            $v->field('password_confirmation', ['required', 'password']);

            if($data['password'] !== $data['password_confirmation']) throw new CustomException('Password tidak cocok');

            $checkToken = ResetPassword::getToken($data['token']);
            $updateUser = User::updateByEmail($checkToken->email, [
                'password_hash' => password_hash($data['password'], PASSWORD_BCRYPT)
            ]);

            if(!$updateUser) throw new CustomException('Terjadi kesalahan');
            
            ResetPassword::updateToken($data['token']);
            ResponseHandler::setResponse('Berhasil mengubah password');
            header('location:' . URL . '/auth/login/index');

        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/auth/login/index');
        }
    }

}
