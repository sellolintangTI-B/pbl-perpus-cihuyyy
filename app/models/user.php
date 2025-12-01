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
        $values = [];
        $fields = [];
        $params = [];
        $conn = parent::getConnection();
        foreach ($data as $key => $value) {
            $fields[] = $key;
            $params[] = ":$key";
            $values[] = $value;
        }

        $implodedFields = implode(', ', $fields);
        $implodedParams = implode(', ', $params);
        $q = $conn->prepare("INSERT INTO users ($implodedFields) VALUES ($implodedParams)");
        $q->execute($values);

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

    public static function getByUniqueField($email = "", $id_number = "", $phoneNumber = "")
    {
        $conn = parent::getConnection();
        $clauses = "";
        $value = "";
        if(!empty($email)) {
            $clauses = "email = ?";
            $value = $email;
        } 

        if(!empty($id_number)) {
            $clauses = "id_number = ?";
            $value = $id_number;
        }

        if(!empty($phoneNumber)) {
            $clauses = "phone_number = ?";
            $value = $phoneNumber;
        }

        $q = $conn->prepare("SELECT * FROM users WHERE $clauses");
        $q->bindValue(1, $value);
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
        $query = "UPDATE users SET id_number = ?, email = ?, first_name = ?, last_name = ?, major = ?, study_program = ?, phone_number = ?, institution = ?, role = ?, is_active = ? WHERE id = ?";
        if (isset($data['image'])) {
            $query = "UPDATE users SET id_number = ?, email = ?, first_name = ?, last_name = ?, major = ?, study_program = ?, phone_number = ?, institution = ?, role = ?, is_active = ?,profile_picture_url = ? WHERE id = ?";
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
    public static function updateProfile($id, $data)
    {
        $conn = parent::getConnection();
        $query = "UPDATE users SET id_number = ?, email = ?, first_name = ?, last_name = ?, major = ?, study_program = ?, phone_number = ?, institution = ? WHERE id = ?";
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

    public static function suspendAccount($userId)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("UPDATE users SET is_suspend = true, suspend_untill = (NOW() AT TIME ZONE 'Asia/Jakarta') + INTERVAL '7 days' WHERE id = :userId RETURNING suspend_untill");
        $q->bindValue(':userId', $userId);
        $q->execute();
        if ($q) {
            $data = $q->fetch(PDO::FETCH_OBJ);
            return $data;
        }
        return false;
    }

    public static function checkUserSuspend($userId)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT is_suspend, TO_CHAR(suspend_untill, 'YYYY-MM-DD') AS suspend_date FROM users WHERE id = :userId");
        $q->bindValue(':userId', $userId);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }
}
