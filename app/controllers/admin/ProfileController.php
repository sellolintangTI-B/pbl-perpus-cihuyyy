<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Utils\Authentication;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Utils\Validator;
use App\Models\User;

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
        $data = User::getById($userId);
        $this->view('admin/profile/index', $data, layoutType: $this::$layoutType['admin']);
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
                "institution" => $_POST['institution'],
            ];

            $validator = new Validator($data);
            $validator->field("first_name", ['required']);
            $validator->field("email", ['required']);
            $validator->field("phone_number", ['required']);
            $validator->field("institution", ['required']);

            if ($validator->error()) throw new CustomException($validator->getErrors());

            $checkById = User::checkIdNumberForUpdate($id, $data['id_number']);
            $checkByEmail = User::checkEmailForUpdate($id, $data['email']);

            if ($checkById) throw new CustomException('NIP / NIM sudah digunakan');
            if ($checkByEmail) throw new CustomException('Email sudah digunakan');

            $update = User::updateProfile($id, $data);
            if ($update) {
                ResponseHandler::setResponse('Berhasil mengubah data');
                header('location:' . URL . '/admin/profile/index');
            } else {
                throw new CustomException('Gagal mengubah data');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/admin/profile/index');
        }
    }
}
