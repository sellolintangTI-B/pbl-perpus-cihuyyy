<?php
namespace App\Controllers\User;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Utils\Validator;
use App\Utils\Authentication;

class RoomController extends Controller{
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
            $date = isset($_GET['date']) ? $_GET['date'] : null;
            $data = $this->room->get();
            $this->view('user/room/index', $data, layoutType: "user");
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getMessage(), "error");
            header('location:' . URL . '/user/room/index');
        }
    }

    public function details($id)
    {
        try {
            $data = $this->room->getById($id);
            if(!$data) throw new CustomException("Data ruangan tidak ditemukan"); 
            $this->view('user/room/details', $data);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            $error = ResponseHandler::getResponse();
            var_dump($error);
        }
    }
}