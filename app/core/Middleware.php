<?php

namespace App\Core;

use App\Utils\Authentication;

class Middleware
{
    private $fullPath;
    private $routes = [
        "Admin" => [

            //BOOKING
            "/admin/booking/index",
            "/admin/booking/details",
            "/admin/booking/create",
            "/admin/booking/check_in",
            "/admin/booking/check_out",
            "/admin/booking/cancel",
            "/admin/booking/search_user",
            "/admin/booking/store",
            "/admin/booking/edit",
            "/admin/booking/update",
            //ROOM
            "/admin/room/index",
            "/admin/room/store",
            "/admin/room/create",
            "/admin/room/detail",
            "/admin/room/edit",
            "/admin/room/update",
            "/admin/room/delete",
            //DASHBOARD
            "/admin/dashboard/index",
            "/admin/dashboard/logout",
            //USER
            "/admin/user/approve",
            "/admin/user/index",
            "/admin/user/store",
            "/admin/user/add_admin",
            "/admin/user/approve_user",
            "/admin/user/update",
            "/admin/user/edit",
            "/admin/user/reset_password",
            "/admin/user/details",
            //FEEBACK
            "/admin/feedback/index",
            //CLOSE LOG 
            "/admin/close/index",
            "/admin/close/store",
            "/admin/close/detail",
            "/admin/close/update",
            "/admin/close/delete",
            "/admin/close/edit",
            //PROFILE
            "/admin/profile/index",
            "/admin/profile/update",
            //ERROR
            "/error/forbidden/index",
            "/error/notfound/index",
            "/auth/logout/logout"
        ],

        "Mahasiswa" => [
            "/user/user/index",
            "/error/forbidden/index",
            "/error/notfound/index",
            // RUANGAN
            "/user/room/index",
            "/user/room/detail",
            "/user/booking/search_user",
            "/user/booking/store",
            "/user/booking/index",
            "/user/booking/detail",
            "/user/booking/cancel_booking",
            "/user/booking/send_feedback",
            //LOGOUT
            "/auth/logout/logout",
            //GUIDE
            "/user/guide/index",
            //PROFILE
            "/user/user/profile",
            "/user/user/update",
            "/user/user/reset_password",
        ],
        "Dosen" => [
            "/user/user/index",
            "/error/forbidden/index",
            "/error/notfound/index",
            // RUANGAN
            "/user/room/index",
            "/user/room/detail",
            "/user/booking/search_user",
            "/user/booking/store",
            "/user/booking/index",
            "/user/booking/detail",
            "/user/booking/cancel_booking",
            "/user/booking/send_feedback",
            //LOGOUT
            "/auth/logout/logout",
            //GUIDE
            "/user/guide/index",
            //PROFILE
            "/user/user/profile",
            "/user/user/update",
            "/user/user/reset_password",
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
        $this->fullPath = $url;
        $this->auth = new Authentication;
        $user = $this->auth->user;

        if (in_array($this->fullPath, $this->exceptionRoutes)) {
            return;
        }

        if (empty($user)) {
            header('location:' . URL . '/auth/login');
        }

        if (!empty($user)) {
            $role = $user['role'] ?? null;
            if ($this->forbidden($role)) {
                header('location:' . URL . '/error/forbidden');
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
