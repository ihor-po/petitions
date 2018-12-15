<?php

namespace App\Models;

use Framework\Model;
use PDO;

require_once ('../framework/Model.php');
/**
 * @property int $user_id
 * @property int $petition_id
 */
class UserPetition extends Model
{
    public static $table = USER_PETITION;                   //name of table
    protected static $_table = USER_PETITION;           //name of table
    protected $usersTable = USERS;                      //name of users table
    protected $petitionsTable = PETITIONS;              //name of petitions table

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
}