<?php
require_once('config/config.php');
require dirname(__DIR__) . '/vendor/autoload.php';
use Dotenv\Dotenv;
$dotEnv = Dotenv::createImmutable(__DIR__ . '/../');
$dotEnv->load();
use App\Core\Controller;
// use App\Utils\Migrate;
// new Migrate;