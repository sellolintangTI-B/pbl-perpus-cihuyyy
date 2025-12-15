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
    require __DIR__ . '/../config/config.php';
} catch (Exception $e) {
    echo "Gagal memuat .env: " . $e->getMessage();
    exit(1);
}

try {
    $data = BookingLog::getLateBookings();
    if ($data) {
        $mailData = [];
        $userIds = [];

        $bookingIds = array_map(function ($item) use (&$mailData, &$userIds) {
            if($item->role !== 'Admin') {
                $mailData[] = [
                    'email' => $item->email,
                    'username' => $item->username,
                    'booking' => (object) [
                        'start_time' => $item->start_time,
                        'end_time' => $item->end_time,
                        'booking_code' => $item->booking_code,
                        'room_name' => $item->name,
                        'floor' => $item->floor
                    ]
                ];
                $userIds[] = $item->user_id;
            }
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
            foreach ($mailData as $item) {
                Mailer::send($item['email'], 'PEMBERITAHUAN', 'booking-cancel.php', [
                    'name' => $item['username'],
                    'booking' => $item['booking'],
                    'reason' => 'Anda telah telat 10 menit dari jadwal booking'
                ]);
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