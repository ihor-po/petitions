<?php

namespace App\Models;

use Framework\Model;
use PDO;
use DateTime;

require_once ('../framework/Model.php');

class Petition extends Model
{
    protected $table = PETITIONS;       //name of table
    protected $usersTable = USERS;      //name of users table

    /**
     * Checking table existence
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
title VARCHAR(90) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
petition_text TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
owner_id INT UNSIGNED NOT NULL,
created_date TIMESTAMP NOT NULL,
FOREIGN KEY (owner_id) REFERENCES $this->usersTable(id) ON UPDATE CASCADE ON DELETE CASCADE
);";
        return parent::createTable($sql);
    }

    /**
     * Creating petition
     * @param array $params
     * @return bool
     */
    public function createPetition(array $params): bool
    {
        $date = new DateTime('NOW');
        $sql = "INSERT INTO $this->table (title, petition_text, owner_id, created_date) 
                VALUES (:title, :petition_text, :owner_id, :created_date)";
        $stmt = parent::db()->prepare($sql);
        return $stmt->execute([
            ':title' => $params['title'],
            ':petition_text' => $params['petition_text'],
            ':owner_id' => $params['owner_id'],
            ':created_date' => $date->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get all petitions
     * @param string $login
     * @return mixed
     */
    public function getAllPetitions() : array
    {
        parent::_instance();
        $stmt = parent::db()->prepare("SELECT * FROM $this->table ORDER BY created_date DESC");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}