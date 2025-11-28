<?php

namespace App\Core;

class App
{
    protected $dir = 'auth';
    protected $controller = 'login';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $path = '/';
        $url = $this->parseURL();
        if (isset($url[0])) {
            $path .= $url[0];
            $this->dir = $url[0];
            unset($url[0]);
        }

        if(isset($url[1])) {
            $this->controller = $url[1];
            $path .= '/' . $this->controller;
            unset($url[1]);
        }

        if (file_exists("app/controllers/$this->dir/{$this->controller}Controller.php")) {
        } else {
            header('location:' . URL . '/error/notfound');
        }

        require_once("app/controllers/$this->dir/" . $this->controller . 'Controller.php');
        $namespace = "app\\controllers\\$this->dir\\";
        $controller = $namespace . $this->controller . "Controller";
        $this->controller = new $controller;

        if (isset($url[2])) {
            if (method_exists($this->controller, $url[2])) {
                $this->method = $url[2];
                unset($url[2]);
            }
        }
        $path .= '/' . $this->method;
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
