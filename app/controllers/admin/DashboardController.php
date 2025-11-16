<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Utils\Authentication;
use App\Utils\DB;

class DashboardController extends Controller
{

    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
    }
    public function index()
    {

        if (isset($_GET['search'])) {
        }
        return $this->view('admin/dashboard/index', layoutType: $this::$layoutType['admin']);
    }


    public function approved() {}
}
