<?php

namespace App\Models;

use Framework\Model;
use PDO;

require_once ('../framework/Model.php');

class UserPetition extends Model
{
    protected $table = USER_PETITION;           //name of table
    protected $usersTable = USERS;              //name of users table
    protected $petitionsTable = PETITIONS;      //name of petitions table

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
user_id INT UNSIGNED NOT NULL,
petition_id INT UNSIGNED NOT NULL,
FOREIGN KEY (user_id) REFERENCES $this->usersTable(id) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN KEY (petition_id) REFERENCES $this->petitionsTable(id) ON UPDATE CASCADE ON DELETE CASCADE
);";
        return parent::createTable($sql);
    }

    /**
     * Creating link user - petition
     * @param array $params
     * @return bool
     */
    public function createLink(array $params): bool
    {
        $sql = "INSERT INTO $this->table (user_id, petition_id) 
                VALUES (:user_id, :petition_id)";
        $stmt = parent::db()->prepare($sql);
        return $stmt->execute([
            ':user_id' => $params['user_id'],
            ':petition_id' => $params['petition_id']
        ]);
    }
}