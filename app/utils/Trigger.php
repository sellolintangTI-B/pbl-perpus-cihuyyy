<?php 
namespace App\Utils;

require dirname(__DIR__) . '/../vendor/autoload.php';
use Dotenv\Dotenv;
$dotEnv = Dotenv::createImmutable(dirname(__DIR__) . '/../');
$dotEnv->load();
use App\Core\Database;
use PDOException;

class Trigger extends Database
{
    public function __construct()
    {
        $conn = parent::getConnection();
        try {
            $path = dirname(__DIR__) . '../../sql/triggers';
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $content = file_get_contents($path . "/" . $file);
                    $conn->exec($content);
                }
            }
            echo "Trigger success";
        } catch (PDOException $e) {
            echo "Error : " . $e->getMessage();
        }
    }
}

new Trigger;

?>