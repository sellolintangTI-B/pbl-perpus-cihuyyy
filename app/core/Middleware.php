<?php
namespace app\core;
use app\utils\Authentication;
class Middleware 
{
    private $fullPath;
    private $routes = [
        "Admin" => [
            "/admin/index",
            "/admin/logout",
            "/httperror/forbidden",
            "/room/index",
            "/room/store",
            "/room/create",
            "/room/detail"
        ],
        "Mahasiswa" => [
            "/user/index",
            "/httperror/forbidden"
        ],
        "Dosen" => [
            "/user/index",
            "/httperror/forbidden"
        ]
    ];

    private $exceptionRoutes = [
        "/auth/login",
        "/auth/register",
        "/auth/signin",
        "/auth/signup"
    ];

    private $auth;

    public function __construct($url)
    {
        $this->fullPath = '/' . ($url[0] ?? '') . '/' . ($url[1] ?? '');
        $this->auth = new Authentication;
        $user = $this->auth->user;

        if (in_array($this->fullPath, $this->exceptionRoutes)) {
            return;
        }

        if (empty($user)) {
            header('location:' . URL . '/auth/login');
        }

        if(!empty($user)) {
            $role = $user['role'] ?? null;
            if($this->forbidden($role)) {
                header('Location:' . URL . '/httperror/forbidden');
                return;
            } 
        }

    }

    public function forbidden($role)
    {
        if (!in_array($this->fullPath, $this->routes[$role])) {
            return true;
        }
    }

}
