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

    // /**
    //  * Creating link user - petition
    //  * @param array $params
    //  * @return bool
    //  */
    // public function createLink(array $params): bool
    // {
    //     $sql = "INSERT INTO $this->table (user_id, petition_id) 
    //             VALUES (:user_id, :petition_id)";
    //     $stmt = parent::db()->prepare($sql);
    //     return $stmt->execute([
    //         ':user_id' => $params['user_id'],
    //         ':petition_id' => $params['petition_id']
    //     ]);
    // }

    /**
     * Obtaining the number of signatures of the petition
     * @param int $id
     * @return int
     */
    public static function getPetitionSignatures(int $id) : int
    {
        $tb = self::$_table;
        parent::_instance();
        $stmt = parent::db()->prepare("SELECT COUNT(id) FROM $tb WHERE petition_id = $id");
        $stmt->execute(['id']);

        return $stmt->fetchColumn();
    }

    /**
     * Obtaining user signature of the petition
     * @param int $petitionId
     * @param int $userId
     * @return bool
     */
    public static function getPetitionUserSignatures(int $petitionId, int $userId) : bool
    {
        $tb = self::$_table;
        parent::_instance();
        $stmt = parent::db()->prepare("SELECT * FROM $tb WHERE petition_id = :petition_id AND user_id = :user_id");
        $stmt->execute([
            'petition_id' => $petitionId,
            'user_id' => $userId
        ]);

        return $stmt->fetchColumn();
    }
}