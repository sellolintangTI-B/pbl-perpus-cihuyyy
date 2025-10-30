<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use app\error\CustomException;

class UserController extends Controller {

    private $user;

    public function __construct()
    {
        $this->user = $this->model('user');
    }

    public function index()
    {

    }

    public function approve($id)
    {
        try {
            $approve = $this->user->approve($id);
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
}