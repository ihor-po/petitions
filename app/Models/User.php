<?php

namespace App\Models;

use Framework\Model;
use PDO;

//require_once ('../framework/Model.php');

class User extends Model
{
    protected $table = USERS; //name of table

    /**
     * Проверка существования таблицы
     * @return bool
     */
    public function tableExist() : bool
    {
        return parent::exist($this->table);
    }

    /**
     * Creating table
     * @return bool
     */
    public function newTable() : bool
    {

        $sql = "CREATE TABLE $this->table (
id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,  
login VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
last_name VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
first_name VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
midle_name VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci, 
email VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, 
password VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
confirmed SMALLINT(1) NOT NULL
);";
        return parent::createTable($sql);
    }

    /**
     * Creating user
     * @param array $params
     * @return bool
     */
    public function createUser(array $params): bool
    {
        $sql = "INSERT INTO $this->table (login, last_name, first_name, midle_name, email, password, confirmed) 
                VALUES (:login, :last_name, :first_name, :midle_name, :email, :password, :confirmed)";
        $stmt = parent::db()->prepare($sql);
        return $stmt->execute([
            ':login' => $params['login'],
            ':last_name' => $params['last_name'],
            ':first_name' => $params['first_name'],
            ':midle_name' => $params['midle_name'],
            ':email' => $params['email'],
            ':password' => $this->hashPassword($params['password']),
            ':confirmed' => $params['confirmed']
        ]);
    }

    /**
     * Get user by login
     * @param string $login
     * @return mixed
     */
    public function getUserByLogin(string $login)
    {
        parent::_instance();
        $stmt = parent::db()->prepare("SELECT * FROM $this->table WHERE login = :login");
        $stmt->execute([':login' => $login]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get user by email
     * @param string $email
     * @return mixed
     */
    public function getUserByEmail(string $email)
    {
        parent::_instance();
        $stmt = parent::db()->prepare("SELECT * FROM $this->table WHERE email = :email");
        $stmt->execute([':email' => $email]);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        return $res;
    }

    /**
     * Confirm user with email
     * @param string $email
     */
    public function confirmUser(string $email)
    {
        parent::_instance();
        $stmt = parent::db()->prepare("UPDATE $this->table SET confirmed = 1 WHERE email = :email");
        $stmt->execute([':email' => $email]);
    }

    /**
     * Хеширование пароля
     * @param string $password
     * @return string
     */
    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

}