<?php

namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\ResponseHandler;
use app\error\CustomException;
use App\Models\Booking;
use App\Models\Feedback;
use App\Models\Room;
use Carbon\Carbon;
use Carbon\Traits\Cast;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FeedbackController extends Controller
{
    public function index()
    {
        try {
            $rooms = Room::get();
            $years = Booking::getAllBookingsYear();
            $params = [];
            $page = 0;

            if (isset($_GET['ruangan'])) {
                $params['ruangan'] = $_GET['ruangan'];
            }

            if(isset($_GET['page']) && !empty($_GET['page'])) $page = $_GET['page'] - 1;

            if(isset($_GET['bulan']) && isset($_GET['tahun'])) {
                $now = Carbon::now('Asia/Jakarta');
                $month = empty($_GET['bulan']) ? $now->format('m') : $_GET['bulan'];
                $year =  empty($_GET['tahun']) ? $now->format('Y') : $_GET['tahun'];
                if(!empty($_GET['bulan'])) {
                    $params['date'] = Carbon::createFromDate((int) $year, (int) $month)->format('Y-m');
                }
            }

            $feedback = Feedback::get($params, $page);
            $count = Feedback::count($params);
            $data = [
                'feedback' => $feedback,
                'room' => $rooms,
                'years' => $years,
                "total_page" => ceil((int)$count->count / 15)
            ];

            $this->view('/admin/feedback/index', $data , 'Admin');
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getMessage(), 'error');
            header('location:' . URL . '/admin/feedback/index');
        }
    }

    public function export()
    {
        try {
            $params = [];
            $filename = "DataFeedbackPeminjaman";
            if (isset($_GET['ruangan']) && !empty($_GET['ruangan'])) {
                $params['ruangan'] = $_GET['ruangan'];
                $room = Room::getById($_GET['ruangan']);
                $ruangan = str_replace(" ", "_", $room->name);
                $filename .= "_$ruangan";
            }

            if(isset($_GET['bulan']) && isset($_GET['tahun'])) {
                if(!empty($_GET['bulan']) && !empty($_GET['tahun'])) {
                    $params['date'] = Carbon::createFromDate((int) $_GET['tahun'], (int) $_GET['bulan'])->format('Y-m');
                    $bulan = $_GET['bulan'];
                    $tahun = $_GET['tahun'];
                    $filename .= "_$bulan";
                    $filename .= "_$tahun";
                }
            }

            $data = Feedback::get($params);

            $spreadsheet = new Spreadsheet();
            $activeWorksheet = $spreadsheet->getActiveSheet();
            $activeWorksheet->setCellValue('A1', 'No');
            $activeWorksheet->setCellValue('B1', 'Kode Booking');
            $activeWorksheet->setCellValue('C1', 'Nama Pengguna');
            $activeWorksheet->setCellValue('D1', 'Ruangan');
            $activeWorksheet->setCellValue('E1', 'Tanggal Booking');
            $activeWorksheet->setCellValue('F1', 'Rating');
            $activeWorksheet->setCellValue('G1', 'Deskripsi');
            $rowNumber = 2;
            $no = 1;
            foreach ($data as $key => $value) {
                $activeWorksheet->setCellValue('A' . $rowNumber, $no);
                $activeWorksheet->setCellValue('B' . $rowNumber, $value->booking_code);
                $activeWorksheet->setCellValue('C' . $rowNumber, $value->name);
                $activeWorksheet->setCellValue('D' . $rowNumber, $value->room_name);
                $activeWorksheet->setCellValue('E' . $rowNumber, Carbon::parse($value->start_time)->translatedFormat('l, d M Y'));
                $activeWorksheet->setCellValue('F' . $rowNumber, $value->rating);
                $activeWorksheet->setCellValue('G' . $rowNumber, $value->feedback);
                $no++;
                $rowNumber++;
            }

            foreach (range('A', 'G') as $columnID) {
                $activeWorksheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            $lastRow = $rowNumber - 1;
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];

            $activeWorksheet->getStyle('A1:G' . $lastRow)->applyFromArray($styleArray);
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit;
        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), 'error');
            header('location:' . URL . '/admin/feedback/index');
        }
    }
}
