<?php

namespace App\Models;

use App\Core\Database;
use Pdo;

class User extends Database
{

    public static function get()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM users ORDER BY is_active ASC");
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function insert($data)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("INSERT INTO users (id_number, email, password_hash, first_name, last_name, institution, phone_number, role, activation_proof_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
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

        if ($q) {
            return true;
        }
    }

    public static function getByIdNumber($id_number)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM users WHERE id_number = ?");
        $q->bindParam(1, $id_number, PDO::PARAM_STR);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public static function getById($id)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $q->bindParam(1, $id, PDO::PARAM_STR);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function getByEmail($email)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $q->bindParam(1, $email, PDO::PARAM_STR);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public static function getByEmailOrIdNumber($emailOrIdNumber)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM users WHERE email = ? OR id_number = ?");
        $q->bindParam(1, $emailOrIdNumber, PDO::PARAM_STR);
        $q->bindParam(2, $emailOrIdNumber, PDO::PARAM_STR);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public static function approve($id)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("UPDATE users SET is_active = true WHERE id = ?");
        $q->bindParam(1, $id, PDO::PARAM_STR);
        $q->execute();
        if ($q) {
            return true;
        }
    }

    public static function update($id, $data)
    {
        $conn = parent::getConnection();
        $query = "UPDATE users SET id_number = ?, email = ?, first_name = ?, last_name = ?, major = ?, phone_number = ?, institution = ?, role = ? WHERE id = ?";
        if (isset($data['image'])) {
            $query = "UPDATE users SET id_number = ?, email = ?, first_name = ?, last_name = ?, major = ?, phone_number = ?, institution = ?, role = ?, profile_picture_url = ? WHERE id = ?";
        }
        $q = $conn->prepare($query);
        $i = 1;
        foreach ($data as $key => $value) {
            $q->bindParam($i, $data[$key]);
            $i++;
        }
        $q->bindParam($i++, $id);
        $q->execute();
        if ($q) return true;
        return false;
    }

    public static function delete($id)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("DELETE FROM users WHERE id = ?");
        $q->bindParam(1, $id);
        $q->execute();
        if ($q) return true;
        return false;
    }

    public static function resetPassword($id, $password)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $q->bindParam(1, $password);
        $q->bindParam(2, $id);
        $q->execute();
        if ($q) return true;
        return false;
    }

    public static function checkEmailForUpdate($id, $email)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT email FROM users WHERE email = ? AND NOT id = ?");
        $q->bindParam(1, $email);
        $q->bindParam(2, $id);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function checkIdNumberForUpdate($id, $id_number)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT id_number FROM users WHERE id_number = ? AND NOT id = ?");
        $q->bindParam(1, $id_number);
        $q->bindParam(2, $id);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);

        return $data;
    }
}
