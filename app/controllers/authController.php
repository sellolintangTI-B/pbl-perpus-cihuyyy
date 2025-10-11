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
        $this->view('auth/register');
    }

    public function signup()
    {
        try {

            $data = [
                "id_number" => $_POST['id_number'],
                "email" => $_POST['email'],
                "password" => password_hash($_POST['password'], PASSWORD_BCRYPT),
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "institution" => "Politeknik Negeri Jakarta",
                "phone_number" => $_POST['phone_number'],
                "role" => $_POST['role'],
                "image" => $_FILES
            ];

            $validator = new Validator($data);
            $validator->field("id_number", ["required"]);
            $validator->field("email", ["required", "email"]);
            $validator->field("password", ["required"]);
            $validator->field("first_name", ["required"]);
            $validator->field("last_name", ["required"]);
            $validator->field("institution", ["required"]);
            $validator->field("phone_number", ["required"]);
            $validator->field("role", ["required"]);
            $validator->field("image", ["required"]);

            $errors = $validator->error();
            if ($errors) {
                throw new CustomException($validator->getErrors());
            }

            $checkIfEmailExist = $this->user->getByEmail($data['email']);
            if ($checkIfEmailExist) {
                throw new CustomException(['email' => "Email sudah terdaftar"]);
            }

            $file = $_FILES['activation_proof']['tmp_name'];
            $allowedMimes = ["image/jpeg", "image/png", "image/jpg"];
            $getFileInfo = getimagesize($file);
            if (!in_array($getFileInfo['mime'], $allowedMimes)) {
                throw new CustomException(['image' => "File tidak didukung"]);
            }

            $newPath = 'storage/' . $_FILES['activation_proof']['name'];
            move_uploaded_file($file, __DIR__ . "/../../public/" . $newPath); 
            $data['image'] = $newPath;

            $insertData = $this->user->insert($data);
            if($insertData) {
                ResponseHandler::setResponse("Berhasil memasukan data");
                header('location:'. URL . '/auth/register');
            }

        } catch (CustomException $e) {
            ResponseHandler::setResponse($e->getErrorMessages(), "error");
            header('location:' . URL . '/auth/register');
        }
    }
}
