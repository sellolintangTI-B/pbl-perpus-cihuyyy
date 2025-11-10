<?php

namespace App\Controllers\user;
use App\Core\Controller;

class GuideController extends Controller {

    public function index()
    {
        $this->view('user/panduan/index');
    }
}