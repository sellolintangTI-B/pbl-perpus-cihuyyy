<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Utils\Validator;
use App\Models\User;
use App\Utils\DB;
use Exception;

class UserController extends Controller
{

    public function index()
    {
        try {
            $type = isset($_GET['type']) ? $_GET['type'] : null;
            $search = isset($_GET['search']) ? $_GET['search'] : null;
            $users = User::get();
            if (!empty($search)) $searchLower = strtolower($search);
            if (!empty($type) && !empty($search)) {
                $users = DB::get("SELECT * FROM users WHERE (LOWER(first_name) LIKE ? OR LOWER(last_name) LIKE ?) AND role = ? ORDER BY is_active ASC", ["%$searchLower%", "%$searchLower%", $type]);
            } else if (!empty($type)) {
                $users = DB::get("SELECT * FROM users WHERE role = ? ORDER BY is_active ASC", [$type]);
            } else if (!empty($search)) {
                $users = DB::get("SELECT * FROM users WHERE (LOWER(first_name) LIKE ? OR LOWER(last_name) LIKE ?) ORDER BY is_active ASC", ["%$searchLower%", "%$searchLower%"]);
            }
            $data = [
                "no" => 1,
                "users" => $users
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
            ];

            $validator = new Validator($data);
            $validator->field('id_number', ['required']);
            $validator->field('email', ['required']);
            $validator->field('password_hash', ['required']);
            $validator->field('first_name', ['required']);
            $validator->field('last_name', ['required']);
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
                "image" => empty($_FILES['image']['name']) ? null : $_FILES['image']
            ];

            $validator = new Validator($data);
            $validator->field("first_name", ['required']);
            $validator->field("last_name", ['required']);
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
                $file = $_FILES['image']['tmp_name'];
                $allowedMimes = ["image/jpeg", "image/png", "image/jpg"];
                $getFileInfo = getimagesize($file);
                if (!in_array($getFileInfo['mime'], $allowedMimes)) {
                    throw new CustomException(['image' => "File tidak didukung"]);
                }
                $newPath = 'storage/users/' . $_FILES['image']['name'];
                move_uploaded_file($file, dirname(__DIR__) . "/../../public/" . $newPath);
                $data['image'] = $newPath;
            } else {
                unset($data['image']);
            }

            $update = User::update($id, $data);
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
