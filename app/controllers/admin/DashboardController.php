<?php
namespace App\Controllers\Admin;
use App\Core\Controller;
use App\Utils\Authentication;

class DashboardController extends Controller {

    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
    }
    public function index()
    {
        return $this->view('admin/dashboard/index', layoutType: $this::$layoutType['admin']);
    }


    public function approved()
    {
        
    }

}