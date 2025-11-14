<?php

namespace App\Core;

class App
{

    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $path = '/';
        $url = $this->parseURL();
        if (isset($url[0])) {
            $path = $path . $url[0];
            if (file_exists("app/controllers/$url[0]/$url[1]Controller.php")) {
                $this->controller = $url[1];
                $path = $path . '/' . $this->controller;
                unset($url[1]);
            } else {
                header('location:' . URL . '/error/notfound');
            }
        }

        require_once("app/controllers/$url[0]/" . $this->controller . 'Controller.php');
        $namespace = "app\\controllers\\$url[0]\\";
        $controller = $namespace . $this->controller . "Controller";
        $this->controller = new $controller;
        unset($url[0]);

        if (isset($url[2])) {
            if (method_exists($this->controller, $url[2])) {
                $this->method = $url[2];
                unset($url[2]);
            }
        }
        $path = $path . '/' . $this->method;
        new Middleware($path);
        if (!empty($url)) {
            $this->params = array_values($url);
        }
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = strtolower($_GET['url']);
            $url = rtrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
