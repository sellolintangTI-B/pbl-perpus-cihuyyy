<?php
namespace App\Controllers;
use app\core\Controller;
use app\utils\Authentication;
use app\utils\Validator;
class User extends Controller {

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