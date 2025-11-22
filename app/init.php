<?php
require dirname(__DIR__) . '/vendor/autoload.php';
use Carbon\Carbon;
use Dotenv\Dotenv;
$dotEnv = Dotenv::createImmutable(__DIR__ . '/../');
$dotEnv->load();
Carbon::setLocale('id');
require_once('config/config.php');