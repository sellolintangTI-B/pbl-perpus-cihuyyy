<?php

class Middleware 
{
    private $routes = [
        "Admin" => [
            "/admin/index",
            "/admin/logout",
            "/httperror/forbidden"
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
        "/auth/logout"
    ];

    private $auth;

    public function __construct($url)
    {
        $fullPath = '/' . ($url[0] ?? '') . '/' . ($url[1] ?? '');
        $this->auth = new Authentication;
        $user = $this->auth->user;

        if (in_array($fullPath, $this->exceptionRoutes)) {
            var_dump(true);
            return;
        }

        if (empty($user)) {
            header('location:' . URL . '/auth/login');
        }

        $role = $user['role'] ?? null;


        if (!in_array($fullPath, $this->routes[$role])) {
            header('Location:' . URL . '/httperror/forbidden');
        }
    }
}
