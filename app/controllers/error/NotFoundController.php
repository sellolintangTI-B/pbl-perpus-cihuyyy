<?php

namespace App\Controllers\Error;

use App\Core\Controller;

class NotFoundController extends Controller {
    public function index()
    {
        echo "<h1> 404 Not Found </h1>";
    }
}