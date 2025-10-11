<?php
class User extends Database {

    public function insert($data) {
        $q = $this->conn->prepare("INSERT INTO users (id_number, email, password_hash, first_name, last_name, institution, phone_number, role, activation_proof_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $q->bindParam(1, $data['id_number'], PDO::PARAM_STR);
        $q->bindParam(2, $data['email'], PDO::PARAM_STR);
        $q->bindParam(3, $data['password'], PDO::PARAM_STR);
        $q->bindParam(4, $data['first_name'], PDO::PARAM_STR);
        $q->bindParam(5, $data['last_name'], PDO::PARAM_STR);
        $q->bindParam(6, $data['institution'], PDO::PARAM_STR);
        $q->bindParam(7, $data['phone_number'], PDO::PARAM_STR);
        $q->bindParam(8, $data['role'], PDO::PARAM_STR);
        $q->bindParam(9, $data['image'], PDO::PARAM_STR);
        $q->execute();

        if($q) {
            return true;
        }

    }

    public function getByIdNumber($id_number)
    {
        $q = $this->conn->prepare("SELECT * FROM users WHERE id_number = ?");
        $q->bindParam(1, $id_number, PDO::PARAM_STR);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getByEmail($email) 
    {
        $q = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $q->bindParam(1, $email, PDO::PARAM_STR);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
}