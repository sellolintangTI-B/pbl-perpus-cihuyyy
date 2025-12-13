<?php

namespace App\Models;

use App\Core\Database;
use Pdo;

class User extends Database
{

    public static function get($params = [], $page = 1)
    {
        $where = [];
        $values = [];
        $conn = parent::getConnection();
        $stmt = "SELECT * FROM users ";

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if ($key == "first_name" && !empty($value)) {
                    $where[] = "CONCAT(first_name, ' ', last_name) ILIKE :name";
                    $values[] = "%$value%";
                } else {
                    $where[] = "$key = :$key";
                    $values[] = $value;
                }
            }
        }

        if (!empty($where)) {
            $whereClauses = implode(' AND ', $where);
            $stmt .= "WHERE " . $whereClauses;
        }

        $stmt .= " ORDER BY is_active ASC, created_at LIMIT 15 OFFSET 15 * $page";
        $q = $conn->prepare($stmt);
        $q->execute($values);
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function count($params)
    {
        $where = [];
        $values = [];
        $conn = parent::getConnection();
        $stmt = "SELECT COUNT(id) FROM users ";

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if ($key == "first_name" && !empty($value)) {
                    $where[] = "CONCAT(first_name, ' ', last_name) ILIKE :name";
                    $values[] = "%$value%";
                } else {
                    $where[] = "$key = :$key";
                    $values[] = $value;
                }
            }
        }

        if (!empty($where)) {
            $whereClauses = implode(' AND ', $where);
            $stmt .= "WHERE " . $whereClauses;
        }
        $q = $conn->prepare($stmt);
        $q->execute($values);
        $data = $q->fetch(PDO::FETCH_OBJ);
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
        if (!empty($email)) {
            $clauses = "email = ?";
            $value = $email;
        }

        if (!empty($id_number)) {
            $clauses = "id_number = ?";
            $value = $id_number;
        }

        if (!empty($phoneNumber)) {
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

    public static function approve($id, $activeUntill)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("UPDATE users SET is_active = true, active_periode = ? WHERE id = ? RETURNING *");
        $q->bindParam(1, $activeUntill);
        $q->bindParam(2, $id, PDO::PARAM_STR);
        $q->execute();
        if ($q) {
            $data = $q->fetch(PDO::FETCH_OBJ);
            return $data;
        }
        return false;
    }

    public static function update($id, $data)
    {
        $fields = [];
        $values = [];
        $conn = parent::getConnection();
        foreach($data as $key => $value) {
            $fields[] = "$key = :$key";
            $values[] = $value;
        }
        $values[] = $id;

        $fields = implode(',', $fields);
        $query = "UPDATE users SET $fields WHERE id = :id RETURNING *";
        $q = $conn->prepare($query);
        $q->execute($values);
        if ($q) {
            $data = $q->fetch(PDO::FETCH_OBJ);
            return $data;
        }
        return false;
    }

    public static function updateProfile($id, $data)
    {
        $conn = parent::getConnection();
        $fields = [];
        $values = [];

        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $values[] = $value;
        }
        $values[] = $id;
        $fields = implode(', ', $fields);
        $query = "UPDATE users SET $fields WHERE id = :id";
        $q = $conn->prepare($query);
        $q->execute($values);
        if ($q) return true;
        return false;
    }

    public static function delete($id)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("DELETE FROM users WHERE id = ? RETURNING *");
        $q->bindParam(1, $id);
        $q->execute();
        if ($q) {
            return $q->fetch(PDO::FETCH_OBJ);
        } else {
            return false;
        }
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
        $q = $conn->prepare("SELECT suspend_count ,is_suspend, TO_CHAR(suspend_untill, 'YYYY-MM-DD') AS suspend_date FROM users WHERE id = :userId");
        $q->bindValue(':userId', $userId);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }
    
    public static function getActiveUserCount()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("select count(*) from users where role != 'Admin' and is_active = true");
        $q->execute();
        $data = $q->fetchColumn();
        return $data;
    }

    public static function getNeedConfirmationAccountCount()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("select count (*) from users where is_active = false");
        $q->execute();
        $data = $q->fetchColumn();
        return $data;
    }

    public static function resetSuspend()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("UPDATE users SET suspend_count = 0, is_suspend = null, suspend_untill = null 
        WHERE id IN (SELECT id FROM users WHERE TO_CHAR(suspend_untill, 'YYYY-MM-DD') = TO_CHAR(NOW() AT TIME ZONE 'Asia/Jakarta', 'YYYY-MM-DD')) RETURNING email");
        $q->execute();
        if($q) {
            $data = $q->fetchAll(PDO::FETCH_OBJ);
            return $data;
        }
        return false;
    }

}


