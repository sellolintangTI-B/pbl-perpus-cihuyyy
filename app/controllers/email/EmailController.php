<?php

namespace App\Controllers\email;

use App\Core\Controller;

class EmailController extends Controller
{
    public function reset_password()
    {
        $this->view('email/reset-password');
    }
}
