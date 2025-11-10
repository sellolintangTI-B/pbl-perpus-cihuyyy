<?php

namespace App\Controllers\User;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use app\models\Room;
use App\Utils\Validator;
use App\Utils\Authentication;

class RoomController extends Controller
{
    private $room;
    private $user;
    private $authUser;

    public function __construct()
    {
        $this->room = $this->model('room');
        $this->user = $this->model('user');
        $this->authUser = new Authentication;
    }
    public function index()
    {
        try {
            $data = Room::get();
            $this->view('user/beranda/index', $data, layoutType: $this::$layoutType['civitas']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getMessage(), "error");
            header('location:' . URL . '/user/room/index');
        }
    }

    public function details($id)
    {
        try {
            $data = $this->room->getById($id);
            if (!$data) throw new CustomException("Data ruangan tidak ditemukan");
            $this->view('user/room/details', $data);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            $error = ResponseHandler::getResponse();
            var_dump($error);
        }
    }
}
