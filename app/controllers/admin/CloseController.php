<?php


namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use app\error\CustomException;
use App\Utils\Authentication;
use App\Utils\Validator;

class CloseController extends Controller {
    public function index()
    {
        try {
            //code...
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/close/');
        }
    }

    public function store()
    {
        try {
            $authUser = new Authentication;
            $data = [
                'close_date' => $_POST['date'],
                'reason' => $_POST['reason'],
                'created_by' => $authUser->user['id']
            ];

            $validator = new Validator($data);
            $validator->field('close_date', ['required']);
            $validator->field('reason', ['required']);
            if($validator->error()) throw new CustomException($validator->getErrors());

            
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/close/');
        }
    }

    public function detail()
    {
        try {
            //code...
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/close/');
        }
    }

    public function edit()
    {
        try {
            //code...
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/close/');
        }
    }

    public function update()
    {
        try {
            //code...
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/close/');
        }
    }

    public function delete()
    {
        try {
            //code...
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');;
            header('location:' . URL . '/admin/close/');
        }
    }
}