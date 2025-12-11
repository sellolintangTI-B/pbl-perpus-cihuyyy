
<?php
require __DIR__ . '/../vendor/autoload.php';

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
    $users = User::resetSuspend();
    if($users) {
        foreach($users as $user) {
            Mailer::send($user->email, 'PEMBERITAHUAN', 'Anda sudah melalui masa suspend, akun anda sudah aktif kembali');
        }
    }

} catch (Throwable $e) {
    $errorMsg = "[" . date('Y-m-d H:i:s') . "] ERROR: " . $e->getMessage() . "\n";
    file_put_contents($logFile, $errorMsg, FILE_APPEND);
    echo $errorMsg;
}