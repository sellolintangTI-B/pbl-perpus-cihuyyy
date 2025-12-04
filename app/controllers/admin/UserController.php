<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Utils\Validator;
use App\Models\User;
use App\Utils\DB;
use App\Utils\FileHandler;
use Exception;

class UserController extends Controller
{

    public function index()
    {
        try {
            $params = [];
            $page = 0;
            if(isset($_GET['status']) && !empty($_GET['status'])) {
                if($_GET['status'] == 'Active') {
                    $params['is_active'] = 1;
                } elseif($_GET['status'] == 'Inactive') {
                    $params['is_active'] = 0;
                }
            }

            if(isset($_GET['type']) && !empty($_GET['type'])) $params['role'] = $_GET['type'];

            if(isset($_GET['search']) && !empty($_GET['search'])) $params['first_name'] = $_GET['search'];

            if(isset($_GET['page']) && !empty($_GET['page'])) $page = $_GET['page'] - 1;

            $countUsers = User::count();

            $users = User::get($params, $page);
            $data = [
                "no" => 1,
                "users" => $users,
                "total_page" => ceil((int)$countUsers->count / 15)
            ];

            return $this->view('admin/users/index', $data, layoutType: $this::$layoutType['admin']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/admin/dashboard/index');
        }
    }


    public function details($id)
    {
        try {
            $data = User::getById($id);
            if (!$data) throw new CustomException('User tidak ditemukan');
            $this->view('admin/users/detail', $data, layoutType: $this::$layoutType['admin']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/user/index');
        }
    }

    public function approve($id)
    {
        try {
            $approve = User::approve($id);
            if ($approve) {
                ResponseHandler::setResponse("Akun berhasil disetujui, akun sudah aktif");
                header('location:' . URL . '/admin/user/index');
            } else {
                throw new CustomException('Gagal menyetujui akun');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/user/index');
        }
    }

    public function add_admin()
    {
        try {
            return $this->view('admin/users/create', layoutType: "Admin");
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/user/index');
        }
    }

    public function store()
    {
        try {
            $data = [
                "id_number" => $_POST["id_number"],
                "email" => $_POST["email"],
                "password_hash" => $_POST["password"],
                "first_name" => $_POST["first_name"],
                "last_name" => $_POST["last_name"],
                "institution" => "Politeknik Negeri Jakarta",
                "study_program" => $_POST['prodi'],
                "phone_number" => $_POST["phone_number"],
                "major" => $_POST["major"],
                "role" => $_POST['role'],
                "is_active" => true
            ];

            $validator = new Validator($data);
            $validator->field('id_number', ['required']);
            $validator->field('email', ['required']);
            $validator->field('password_hash', ['required']);
            $validator->field('first_name', ['required']);
            $validator->field('study_program', ['required']);
            $validator->field('phone_number', ['required']);
            $validator->field('major', ['required']);

            if ($validator->error()) throw new CustomException($validator->getErrors());

            $checkByIdNumber = User::getByIdNumber($data['id_number']);
            $checkByEmail = User::getByEmail($data['email']);

            if ($checkByIdNumber) throw new CustomException('NIM / NIP sudah terdaftar');
            if ($checkByEmail) throw new CustomException('Email sudah terdaftar');

            $data['password_hash'] = password_hash($data['password_hash'], PASSWORD_BCRYPT);
            $insert = User::insert($data);
            if ($insert) {
                ResponseHandler::setResponse("Berhasil menambahkan akun admin");
                header('location:' . URL . '/admin/user/index');
            } else {
                throw new CustomException("Gagal memasukan data admin");
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/admin/user/add_admin');
        }
    }

    public function edit($id)
    {
        try {
            $data = User::getById($id);
            return $this->view('admin/users/edit', data: $data, layoutType: "Admin");
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/user');
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
                "institution" => $_POST['institution'],
                "role" => $_POST["role"],
                "image" => empty($_FILES['image']['name']) ? null : $_FILES['image'],
                "is_active" => $_POST['status']
            ];

            $validator = new Validator($data);
            $validator->field("first_name", ['required']);
            $validator->field("email", ['required']);
            $validator->field("phone_number", ['required']);
            $validator->field("institution", ['required']);
            $validator->field("role", ['required']);

            if ($validator->error()) throw new CustomException($validator->getErrors());

            $checkById = User::checkIdNumberForUpdate($id, $data['id_number']);
            $checkByEmail = User::checkEmailForUpdate($id, $data['email']);

            if ($checkById) throw new CustomException('NIP / NIM sudah digunakan');
            if ($checkByEmail) throw new CustomException('Email sudah digunakan');

            if (!is_null($data['image'])) {
                $allowedMimes = ["image/jpeg", "image/png", "image/jpg"];
                $getFileInfo = getimagesize($data['image']);
                if (!in_array($getFileInfo['mime'], $allowedMimes)) {
                    throw new CustomException(['image' => "File tidak didukung"]);
                }
                $path = FileHandler::save($data['image'], 'users/profile');
                $data['image'] = $path;
            } else {
                unset($data['image']);
            }

            $update = User::updateProfile($id, $data);
            if ($update) {
                ResponseHandler::setResponse('Berhasil mengubah data');
                header('location:' . URL . '/admin/user');
            } else {
                throw new CustomException('Gagal mengubah data');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . "/admin/user/edit/$id");
        }
    }

    public function delete($id)
    {
        try {
            $checkById = User::getById($id);
            if (!$checkById) throw new CustomException('Data tidak ditemukan');

            $data = User::delete($id);
            if ($data) {
                ResponseHandler::setResponse('Berhasil menghapus data');
                header('location:' . URL . '/admin/user/index');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/user/index');
        }
    }

    public function reset_password($id)
    {
        try {
            $data = [
                "password" => $_POST['password'],
                "confirm_password" => $_POST['password_confirmation']
            ];

            $validator = new Validator($data);
            $validator->field('password', ['required']);
            $validator->field('confirm_password', ['required']);
            if ($validator->error()) throw new CustomException($validator->getErrors());

            if ($data['password'] !== $data['confirm_password']) throw new CustomException('Password tidak sama');
            $checkById = User::getById($id);
            if (!$checkById) throw new CustomException('Data tidak ditemukan');

            $encryptedPass = password_hash($data['password'], PASSWORD_BCRYPT);
            $update = User::resetPassword($id, $encryptedPass);
            if ($update) {
                ResponseHandler::setResponse('Berhasil mengubah password user');
                header('location:' . URL . '/admin/user/index');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/user/edit/' . $id);
        }
    }
}
