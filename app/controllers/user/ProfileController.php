<?php

namespace App\Controllers\User;

use App\Core\Controller;
use App\Utils\Authentication;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Utils\Validator;
use App\Models\User;
use App\Models\Suspension;
use App\Utils\FileHandler;

class ProfileController extends Controller
{
    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
    }

    public function index()
    {
        $userId = $this->authUser->user['id'];

        $suspension = Suspension::checkSupensionsByUserId($userId);
        $data = [
            'data' => User::getById($userId),
            'suspension' => $suspension
        ];
        $this->view('user/profile/index', $data, layoutType: $this::$layoutType['civitas']);
    }

    public function update_picture($id)
    {
        try {
            $file = $_FILES['profile_picture'];
            $path = FileHandler::save($file, 'users/profile');
            // $updateProfile = User::updateProfile();
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . "/user/profile/index");
        }
    }
    public function update($id)
    {
        try {
            $data = [
                "id_number" => $_POST["id_number"],
                "email" => $_POST["email"],
                "first_name" => $_POST["first_name"],
                "last_name" => $_POST["last_name"],
                "major" => $_POST['major'],
                "study_program" => $_POST['study_program'],
                "phone_number" => $_POST["phone_number"],
            ];

            $validator = new Validator($data);
            $validator->field("first_name", ['required']);
            $validator->field("email", ['required']);
            $validator->field("phone_number", ['required']);
            $validator->field("major", ['required']);
            $validator->field("study_program", ['required']);

            if ($validator->error()) throw new CustomException($validator->getErrors());

            $checkById = User::checkIdNumberForUpdate($id, $data['id_number']);
            $checkByEmail = User::checkEmailForUpdate($id, $data['email']);

            if ($checkById) throw new CustomException('NIP / NIM sudah digunakan');
            if ($checkByEmail) throw new CustomException('Email sudah digunakan');

            $update = User::updateProfile($id, $data);
            if ($update) {
                ResponseHandler::setResponse('Berhasil mengubah data');
                header('location:' . URL . '/user/profile/index');
            } else {
                throw new CustomException('Gagal mengubah data');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . "/user/profile/index");
        }
    }

    public function reset_password($id)
    {
        try {
            $data = [
                "current_password" => $_POST['current_password'],
                "password" => $_POST['password'],
                "confirm_password" => $_POST['password_confirmation']
            ];
            $validator = new Validator($data);
            $validator->field('current_password', ['required']);
            $validator->field('password', ['required']);
            $validator->field('confirm_password', ['required']);
            if ($validator->error()) throw new CustomException($validator->getErrors());

            $checkIfUserExist = User::getById($id);
            if (!$checkIfUserExist) throw new CustomException('User not found');
            if (!password_verify($data['current_password'], $checkIfUserExist->password_hash)) throw new CustomException('Password yang anda masukkan salah!');

            if ($data['password'] !== $data['confirm_password']) throw new CustomException('Konfirmasi Password tidak sama');
            $checkById = User::getById($id);
            if (!$checkById) throw new CustomException('Data tidak ditemukan');

            $encryptedPass = password_hash($data['password'], PASSWORD_BCRYPT);
            $update = User::resetPassword($id, $encryptedPass);
            if ($update) {
                ResponseHandler::setResponse('Berhasil mengubah password user');
                $_SESSION['reset_pass_old'] = null;
                $this->redirectWithOldInput('/user/profile/index');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            $this->redirectWithOldInput('/user/profile/index', $_POST, session_name: 'reset_pass_old');
        }
    }
}
