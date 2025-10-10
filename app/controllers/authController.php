<?php

class Auth extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = $this->model('user');
    }

    public function register()
    {
        $this->view('auth/register', layoutType: $this::$layoutType["default"]);
    }

    public function signup()
    {
        try {
            // $data = [
            //     "id_number" => "asdf",
            //     "email" => "farrelmaahira123@gmail.com",
            //     "password" => "farrel123",
            //     "first_name" => "farrel maahira",
            //     "last_name" => "agraprana nugraha",
            //     "institution" => "politeknik negeri jakarta",
            //     "phone_number" => "087795774940",
            //     "role" => "Mahasiswa"
            // ];
            $data = $_POST;
            $validator = new Validator($data);
            $validator->field("id_number", ["required"]);
            $validator->field("email", ["required", "email"]);
            $errors = $validator->error();
            if ($errors) {
                throw new CustomException($validator->getErrors());
            }

            $checkIfEmailExist = $this->user->getByEmail($data['email']);
            if ($checkIfEmailExist) {
                throw new CustomException("Email sudah terdaftar");
            }

            $insertData = $this->user->insert($data);

            if($insertData) {
                $_SESSION['success'] = "Berhasil memasukan data";
                header('location:'. BASE_URI . '/auth/register');
            }
        } catch (CustomException $e) {
            var_dump($e->getErrorMessages());
            ErrorHandler::setError($e->getErrorMessages());
            header('location:' . BASE_URI . '/auth/register');
        }
    }
}
