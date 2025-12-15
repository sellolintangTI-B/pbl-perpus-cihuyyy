<?php


namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use App\Error\CustomException;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\LibraryClose;
use App\Utils\Authentication;
use App\Utils\Mailer;
use App\Utils\Validator;
use Carbon\Carbon;

class CloseController extends Controller
{
    public function index()
    {
        try {
            $page = 0;

            if (isset($_GET['page'])) $page = $_GET['page'];

            $data = LibraryClose::get($page);
            $count = LibraryClose::count();

            $data = [
                'close' => $data,
                'total_page' => ceil((int) $count->count / 15)
            ];

            $this->view('/admin/close_schedule/index', $data, layoutType: $this::$layoutType['admin']);
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
            if ($closeDate < $nowdate) throw new CustomException('Tdak bisa close dikemarin hari');

            $_SESSION['old_close'] = null;
            $bookingByDate = Booking::getBookingForCancelByDate($closeDate);
            if ($bookingByDate) {
                $mailData = [];
                $bookingIds = array_map(function ($item) use(&$mailData) {
                    $mailData[] = [
                        'email' => $item->email,
                        'username' => $item->username,
                        'role' => $item->role,
                        'booking' => (object) [
                            'start_time' => $item->start_time,
                            'end_time' => $item->end_time,
                            'booking_code' => $item->booking_code,
                            'room_name' => $item->name,
                            'floor' => $item->floor
                        ]
                    ];
                    return $item->id;
                }, $bookingByDate);

                $mailData = array_values(array_filter($mailData, function($item){
                    if($item['role'] !== 'Admin') {
                        return $item;
                    }
                }));

                foreach($mailData as $item) {
                    Mailer::send($item['email'], 'PEMBERITAHUAN', 'booking-cancel.php', [
                        'name' => $item['username'],
                        'booking' => $item['booking'],
                        'reason' => $data['reason']
                    ]);
                }

                $cancelAllBookingByDate = BookingLog::cancelAllBookingByDate($bookingIds, $data['reason'], $data['created_by']);
            }
            $libraryClose = LibraryClose::store($data);

            ResponseHandler::setResponse("Berhasil menambahkan tanggal tutup!", 'success');
            $this->redirectWithOldInput(url: '/admin/close');
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            $this->redirectWithOldInput(url: '/admin/close/create', oldData: $_POST, session_name: 'old_close');
        }
    }

    public function delete($id)
    {
        try {
            $data = LibraryClose::delete($id);
            if ($data) {
                ResponseHandler::setResponse('Berhasil menghapus data');
                header('location:' . URL . '/admin/close/index');
            } else {
                throw new CustomException('Terjadi kesalahan');
            }
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/close/index');
        }
    }
}
