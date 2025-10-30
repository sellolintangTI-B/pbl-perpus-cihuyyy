<?php
namespace app\core;
use App\Utils\Authentication;
class Middleware 
{
    private $fullPath;
    private $routes = [
        "Admin" => [
            //ROOM
            "/admin/room/index",
            "/admin/room/store",
            "/admin/room/create",
            "/admin/room/detail",
            "/admin/room/edit",
            //DASHBOARD
            "/admin/dashboard/index",
            "/admin/dashboard/logout",
            //USER
            "/admin/user/approve",
            //ERROR
            "/error/forbidden/index",
            "/error/notfound/index",
        ],
        "Mahasiswa" => [
            "/user/user/index",
            "/error/forbidden/index",
            "/error/notfound/index",
        ],
        "Dosen" => [
            "/user/user/index",
            "/error/forbidden/index",
            "/error/notfound/index",
        ]
    ];

    private $exceptionRoutes = [
        "/auth/login/index",
        "/auth/login/signin",
        "/auth/register/index",
        "/auth/register/signup",
        "/error/notfound/index",
        // "/guest/index"
    ];

    private $auth;

    public function __construct($url)
    {
        $this->fullPath = '/' . ($url[0] ?? '') . '/' . ($url[1] ?? '') . '/' . ($url[2] ?? '');
        $this->auth = new Authentication;
        $user = $this->auth->user;


        if (in_array($this->fullPath, $this->exceptionRoutes)) {
            return;
        }

        if (empty($user)) {
            header('location:' . URL . '/auth/login/index');
        }

        if(!empty($user)) {
            $role = $user['role'] ?? null;
            if($this->forbidden($role)) {
                header('location:' . URL . '/error/forbidden/index');
            } 
            return;
        }

    }

    public function forbidden($role)
    {
        if (!in_array($this->fullPath, $this->routes[$role])) {
            return true;
        }
    }

}
