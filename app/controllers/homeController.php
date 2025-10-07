<?php


class home extends Controller{
    
    public function index() {
        return $this->views('home/index');
    }
}