<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\User;
use App\Utils\Mailer;

$logFile = __DIR__ . '/scheduler_log.txt';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (Exception $e) {
    echo "Gagal memuat .env: " . $e->getMessage();
    exit(1);
}

try {
    $data = BookingLog::getLateBookings();
    if ($data) {
        $emails = [];
        $userIds = [];

        $bookingIds = array_map(function ($item) use (&$emails, &$userIds) {
            $emails[] = $item->email;
            $userIds[] = $item->user_id;
            return $item->id;
        }, $data);


        foreach($userIds as $id) {
            $checkSuspendUser = User::checkUserSuspend($id);
            $suspension = User::update($id, [
                'suspend_count' => $checkSuspendUser->suspend_count + 1
            ]);
            
            if ($suspension->suspend_count >= 3) {
                $suspendUser = User::suspendAccount($id);
            }
        }

        $cancel = BookingLog::bulkCancel($bookingIds, 'Telat 10 menit');

        if ($cancel) {
            foreach ($emails as $email) {
                Mailer::send($email, 'PEMBERITAHUAN', 'BOOKING ANDA TELAH DI CANCEL KARNA TELAT 10 MENIT DARI JADWAL YANG SUDAH ANDA BOOKING');
            }
        }
    }
    $timestamp = date('Y-m-d H:i:s');
    $msg = "[$timestamp] SUKSES: Auto Cancel dijalankan.\n";
    file_put_contents($logFile, $msg, FILE_APPEND);

} catch (Throwable $e) {
    $errorMsg = "[" . date('Y-m-d H:i:s') . "] ERROR: " . $e->getMessage() . "\n";
    file_put_contents($logFile, $errorMsg, FILE_APPEND);
    echo $errorMsg;
}