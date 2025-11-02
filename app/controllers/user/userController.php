<?php
namespace App\Controllers\User;
use App\Core\Controller;
use App\Utils\Authentication;
use App\Utils\Validator;
class UserController extends Controller {

    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
    }

    public function index()
    {
        $user = $_SESSION['loggedInUser'];
        echo "<h1> Hello " . $user['username'] . "</h1>";
    }

    public function logout()
    {
        $logout = $this->authUser->logout();
        if($logout) {
            header('location:' . URL . '/auth/login');
        }
    }


}