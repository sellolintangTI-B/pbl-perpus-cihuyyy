<?php

namespace App\Controllers;
use app\core\Controller;
class httpErrorController extends Controller {
    public function forbidden()
    {
        echo "<h1> Forbidden </h1>";
    }
}