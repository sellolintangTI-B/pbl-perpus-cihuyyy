<?php

class User extends Controller {

    public function index()
    {
        $user = $_SESSION['loggedInUser'];
        echo "<h1> Hello " . $user['username'] . "</h1>";
    }
}