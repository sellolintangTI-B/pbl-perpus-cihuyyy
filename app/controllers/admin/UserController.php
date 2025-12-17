<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Utils\Validator;
use App\Models\User;
use App\Utils\DB;
use App\Utils\FileHandler;
use App\Utils\Mailer;
use Carbon\Carbon;
use Exception;

class UserController extends Controller
{

    public function index()
    {
        try {
            $params = [];
            $page = 0;
            if (isset($_GET['status']) && !empty($_GET['status'])) {
                if ($_GET['status'] == 'Active') {
                    $params['is_active'] = 1;
                } elseif ($_GET['status'] == 'Inactive') {
                    $params['is_active'] = 0;
                }
            }

            if (isset($_GET['type']) && !empty($_GET['type'])) $params['role'] = $_GET['type'];

            if (isset($_GET['search']) && !empty($_GET['search'])) $params['first_name'] = $_GET['search'];

            if (isset($_GET['page']) && !empty($_GET['page'])) $page = $_GET['page'] - 1;

            $countUsers = User::count($params);

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
            $periode = Carbon::parse($_POST['active_until'])->toDateTimeString();
            $approve = User::approve($id, $periode);
            if ($approve) {
                Mailer::send($approve->email, 'VERIFIKASI AKUN SIMARU', 'activation-alert.php', [
                    'message' => 'Kami dengan senang hati menginformasikan bahwa akun Anda telah <strong>diaktifkan</strong>. Anda sekarang dapat menggunakan semua layanan kami.',
                    'status' => 'activated'
                ]);
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

    public function reject($id)
    {
        try {
            $approve = User::delete($id);
            if ($approve) {
                Mailer::send($approve->email, 'VERIFIKASI AKUN SIMARU', 'activation-alert.php', [
                    'status' => 'deactivated',
                    'message' => 'Kami informasikan verifikasi akun Anda telah <strong>ditolak</strong>. Anda tidak akan dapat mengakses layanan kami.'
                ]);
                ResponseHandler::setResponse("Akun berhasil ditolak");
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
                "id_number" => $_POST["id_number"] ?? null,
                "email" => $_POST["email"] ?? null,
                "password_hash" => $_POST["password"] ?? null,
                "first_name" => $_POST["first_name"] ?? null,
                "last_name" => $_POST["last_name"] ?? null,
                "institution" => "Politeknik Negeri Jakarta" ?? null,
                "study_program" => $_POST['prodi'] ?? null,
                "phone_number" => $_POST["phone_number"] ?? null,
                "major" => $_POST["major"] ?? null,
                "role" => $_POST['role'] ?? null,
                "active_periode" => $_POST['active_until'] ?? null,
                "is_active" => true
            ];

            $validator = new Validator($data);
            $validator->field('id_number', ['required']);
            $validator->field('email', ['required']);
            $validator->field('password_hash', ['required']);
            $validator->field('first_name', ['required']);
            if($data['role'] !== 'Admin') {
                $validator->field('active_periode', ['required']);
                $validator->field('major', ['required']);
                $validator->field('study_program', ['required']);
            } else {
                unset($data['active_periode'], $data['major'], $data['study_program']);
            }

            if ($validator->error()) throw new CustomException($validator->getErrors());

            $checkByIdNumber = User::getByIdNumber($data['id_number']);
            $checkByEmail = User::getByEmail($data['email']);

            if ($checkByIdNumber) throw new CustomException('NIM / NIP sudah terdaftar');
            if ($checkByEmail) throw new CustomException('Email sudah terdaftar');

            $data['password_hash'] = password_hash($data['password_hash'], PASSWORD_BCRYPT);
            $insert = User::insert($data);
            if ($insert) {
                ResponseHandler::setResponse("Berhasil menambahkan akun ");
                $_SESSION['old_users'] = [];
                header('location:' . URL . '/admin/user/index');
            } else {
                throw new CustomException("Gagal memasukan data");
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            $this->redirectWithOldInput(url: '/admin/user/add_admin', oldData: $_POST, session_name: 'old_users');
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
                "major" => $_POST['major'] ?? null,
                "study_program" => $_POST['study_program'] ?? null,
                "phone_number" => $_POST["phone_number"],
                "institution" => $_POST['institution'],
                "role" => $_POST["role"],
                "profile_picture_url" => empty($_FILES['image']['name']) ? null : $_FILES['image'],
                "is_active" => $_POST['status'] ?? 1,
                "active_periode" => $_POST['active_until'] ?? null
            ];

            $validator = new Validator($data);
            $validator->field("first_name", ['required']);
            $validator->field("email", ['required']);
            $validator->field("phone_number", ['required']);
            $validator->field("institution", ['required']);
            $validator->field("role", ['required']);
            if($data['role'] !== 'Admin') {
                $validator->field("active_periode", ['required']);
            }

            if ($validator->error()) throw new CustomException($validator->getErrors());

            $checkById = User::checkIdNumberForUpdate($id, $data['id_number']);
            $checkByEmail = User::checkEmailForUpdate($id, $data['email']);

            if ($checkById) throw new CustomException('NIP / NIM sudah digunakan');
            if ($checkByEmail) throw new CustomException('Email sudah digunakan');

            if (!is_null($data['profile_picture_url'])) {
                $allowedMimes = ["image/jpeg", "image/png", "image/jpg"];
                $getFileInfo = getimagesize($data['profile_picture_url']['tmp_name']);
                if (!in_array($getFileInfo['mime'], $allowedMimes)) {
                    throw new CustomException(['image' => "File tidak didukung"]);
                }
                $path = FileHandler::save($data['profile_picture_url'], 'users/profile');
                $data['profile_picture_url'] = $path;
            } else {
                unset($data['profile_picture_url']);
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

    public function edit_suspend($id)
    {
        try {
            $data = [
                'suspend_count' => $_POST['suspend_point'],
                'suspend_untill' => $_POST['suspend_untill']
            ];

            $v = new Validator($data);
            $v->field('suspend_count', ['required']);

            if(empty($data['suspend_untill'])) unset($data['suspend_untill']);
            
            if($data['suspend_count'] >= 0 && $data['suspend_count'] < 3) {
                $data['suspend_untill'] = null;
                $data['is_suspend'] = 0;
            }

            if($data['suspend_count'] == 3 && empty($data['suspend_untill'])) {
                $data['suspend_untill'] = Carbon::now('Asia/Jakarta')->addDays(7);
                $data['is_suspend'] = true;
            } 

            $update = User::update($id, $data);
            if($update) {
                ResponseHandler::setResponse('Berhasil mengubah suspend user');
                header('location:' . URL . "/admin/user/edit/$id");
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

    public function reset_suspend($id)
    {
        try {

            $user = User::update($id, [
                'suspend_count' => 0,
                'is_suspend' => 0,
                'suspend_untill' => null
            ]);

            if($user) {
                ResponseHandler::setResponse('Berhasil reset suspend user');
                header('location:' . URL . '/admin/user/edit/' . $id);
            } else {
                throw new CustomException('Gagal reset suspend user');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/user/edit/' . $id);
        }
    }
}
