<?php
class guest extends Controller{
    public function index(){
        return $this->view('guest/index', layoutType: $this::$layoutType["default"]);
    }
}