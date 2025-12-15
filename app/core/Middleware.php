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
            "/admin/booking/export",
            //ROOM
            "/admin/room/index",
            "/admin/room/store",
            "/admin/room/create",
            "/admin/room/detail",
            "/admin/room/edit",
            "/admin/room/update",
            "/admin/room/delete",
            "/admin/room/deactivate",
            //DASHBOARD
            "/admin/dashboard/index",
            "/admin/dashboard/logout",
            "/admin/dashboard/search_book",
            "/admin/dashboard/get_chart_data",
            "/admin/dashboard/get_barchart_data",
            "/admin/dashboard/mail",
            //USER
            "/admin/user/approve",
            "/admin/user/index",
            "/admin/user/store",
            "/admin/user/add_admin",
            "/admin/user/approve_user",
            "/admin/user/update",
            "/admin/user/edit",
            "/admin/user/edit_suspend",
            "/admin/user/reset_suspend",
            "/admin/user/reset_password",
            "/admin/user/details",
            "/admin/user/delete",
            "/admin/user/reject",
            //FEEBACK
            "/admin/feedback/index",
            "/admin/feedback/export",
            //CLOSE LOG 
            "/admin/close/index",
            "/admin/close/create",
            "/admin/close/store",
            "/admin/close/detail",
            "/admin/close/update",
            "/admin/close/delete",
            "/admin/close/edit",
            //PROFILE
            "/admin/profile/index",
            "/admin/profile/update",
            "/admin/profile/reset_password",
            "/admin/profile/update_picture",
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
            "/user/profile/index",
            "/user/profile/update",
            "/user/profile/reset_password",
            "/user/profile/update_picture",
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
            "/user/profile/index",
            "/user/profile/update",
            "/user/profile/reset_password",
            "/user/profile/update_picture",
        ]
    ];

    private $exceptionRoutes = [
        "/auth/login/index",
        "/auth/login/signin",
        "/auth/register/index",
        "/auth/password/forget",
        "/auth/password/successfully_sent",
        "/auth/password/new",
        "/auth/register/signup",
        "/email/email/reset_password",
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
