<?php
require dirname(__DIR__) . '/vendor/autoload.php';
use Dotenv\Dotenv;
$dotEnv = Dotenv::createImmutable(__DIR__ . '/../');
$dotEnv->load();
require_once('config/config.php');