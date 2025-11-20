<?php

namespace App\Controllers\Error;

use App\Core\Controller;

class NotFoundController extends Controller
{
    public function index()
    {
        $this->view('error/not-found');
    }
}
