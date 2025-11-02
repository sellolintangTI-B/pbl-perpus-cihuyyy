<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Utils\Validator;
use App\Models\User;

class UserController extends Controller {

    private $user;

    public function __construct()
    {
        $this->user = $this->model('user');
    }

    public function index()
    {
        try {
            $users = User::get();
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

    public function approve_user($id)
    {
        try {
            $data = User::getById($id);
            if(!$data) {
                throw new CustomException('Akun tidak tersedia');
            }
            var_dump($data);
        } catch (CustomException $e) {
            var_dump($e->getErrorMessages());
        }
    }

    public function approve($id)
    {
        try {
            $approve = User::approve($id);
            if($approve) {
                ResponseHandler::setResponse("Akun berhasil disetujui, akun sudah aktif");
                header('location:' . URL . '/admin/dashboard/index');
            } else {
                throw new CustomException('Gagal menyetujui akun');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/dashboard/index');
        }
    }

    public function add_admin()
    {
        try {
    
        }catch(CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:');
        }
    }

    public function store_admin()
    {
        try {
            $data = [
                "id_number" => "123456789",
                "email" => "admin@gmail.com",
                "first_name" => 'nugroho',
                "last_name" => 'nur',
                "password" => 'pass123',
                "phone_number" => '087785774940',
                "institution" => "Politeknik Negeri Jakarta",
                "role" => "Admin",
                "image" => null
            ];

            $validator = new Validator($data);
            $validator->field('id_number', ['required']);
            $validator->field('email', ['required']);
            $validator->field('first_name', ['required']);
            $validator->field('last_name', ['required']);
            $validator->field('password', ['required']);
            $validator->field('phone_number', ['required']);

            if($validator->error()) throw new CustomException($validator->getErrors());

            $checkByIdNumber = User::getByIdNumber($data['id_number']);
            $checkByEmail = User::getByEmail($data['email']);

            if($checkByIdNumber) throw new CustomException('NIM / NIP sudah terdaftar');
            if($checkByEmail) throw new CustomException('Email sudah terdaftar');
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            $insert = User::insert($data);
            if($insert) {
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
    
        }catch(CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:');
        }
    }

    public function update($id)
    {
        try {
            $data = [
                "id_number" => "123456789",
                "email" => "admin@gmail.com",
                "first_name" => 'nugroho',
                "last_name" => 'nur',
                "password" => 'pass123',
                "phone_number" => '087785774940',
                "institution" => "Politeknik Negeri Jakarta",
                "role" => "Admin",
                // "image" => empty($_FILES['file_upload']['name']) ? null : $_FILES['file_upload'] 
            ];

            $validator = new Validator($data);
            $validator->field("id_number", ['required']);
            $validator->field("first_name", ['required']);
            $validator->field("last_name", ['required']);
            $validator->field("email", ['required']);
            $validator->field("password", ['required']);
            $validator->field("phone_number", ['required']);
            $validator->field("institution", ['required']);
            $validator->field("role", ['required']);
            
            if($validator->error()) throw new CustomException($validator->getErrors());

            $update = User::update($id, $data);
            // if($update) {

            // } else {
            //     throw new CustomException();
            // }

        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages());
            header('location:' . URL . "/admin/user/edit/$id");
        }
    }

}