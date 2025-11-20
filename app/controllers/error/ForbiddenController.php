<?php

namespace App\Controllers\Error;

use App\Core\Controller;

class ForbiddenController extends Controller
{
    public function index()
    {
        $this->view('error/forbidden');
    }
}
