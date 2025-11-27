<?php


namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Models\LibraryClose;
use App\Utils\Authentication;
use App\Utils\Validator;
use Carbon\Carbon;

class CloseController extends Controller
{
    public function index()
    {
        try {
            $this->view('/admin/close_schedule/index', layoutType: $this::$layoutType['admin']);
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/close/');
        }
    }
    public function create()
    {
        try {
            $this->view('/admin/close_schedule/create', layoutType: $this::$layoutType['admin']);
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
                'close_date' => $_POST['close_date'],
                'reason' => $_POST['reason'],
                'created_by' => $authUser->user['id']
            ];

            $validator = new Validator($data);
            $validator->field('close_date', ['required']);
            $validator->field('reason', ['required']);
            if ($validator->error()) throw new CustomException($validator->getErrors());

            $closeDate = Carbon::parse($data['close_date'])->toDateString();
            $nowdate = Carbon::now('Asia/Jakarta')->toDateString();
            if($closeDate < $nowdate) throw new CustomException('Tdak bisa close dikemarin hari');
            $_SESSION['old_close'] = null;
            // $libraryClose = LibraryClose::
            ResponseHandler::setResponse("Berhasil menambahkan tanggal tutup!", 'success');
            $this->redirectWithOldInput(url: '/admin/close');
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            $this->redirectWithOldInput(url: '/admin/close/create', oldData: $_POST, session_name: 'old_close');
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
