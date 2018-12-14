<?php

namespace Framework;

use PDO;
use stdClass;

abstract class Model
{
    static protected $db;

    public $id;
    public $object;

    private $_options = ['where' => []];

    /**
     * Проверка существования подключения
     */
    protected static function _instance()
    {
        if (static::$db == null)
        {
            static::DB();
        }
    }

    /**
     * Make connection
     */
    protected static function DB()
    {
        if (null === self::$db) {
            try
            {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT;

                self::$db = new PDO($dsn, DB_USER, DB_PASS);

                // Включаем режим отображения ошибок в PDO
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (\PDOException $ex)
            {
                echo($ex->getMessage());
            }
        }

        return self::$db;
    }

    /**
     * Проверка существования таблицы
     * @return bool
     */
    public static function exist($table) : bool
    {
        $res = false;

        self::_instance();

        $stmt = self::$db->prepare("SHOW TABLES FROM `" . DB_NAME . "` LIKE '" . $table . "'");
        $stmt->execute();

        if (count($stmt->fetchAll(PDO::FETCH_ASSOC)) > 0)
        {
            $res = true;
        }

        return $res;
    }

    /**
     * Creating table
     * @return bool
     */
    public static function createTable($sql) : bool
    {
        try
        {
            self::_instance();

            try {
                $stmt = static::$db->prepare($sql);
                $stmt->execute();
                $res = true;
            } catch (\Exception $ex)
            {
                $res = false;
            }

            $stmt = null;
        }
        catch (\PDOException $ex)
        {
            echo ($ex->getMessage());
        }
        return $res;

    }

    /**
     * Crete class object
     */
    public function __construct($id = null){
        if ($id) {

        }
        else {
            $this->object = new stdClass();
        }
    }

    /**
     * Get value
     */
    public function __get($key) {
        if (isset($this->object->$key)) {
            return $this->object->$key;
        } elseif (isset($this->$key)) {
            return $this->$key;
        }
    }

    /**
     * Set value
     */
    public function __set($key, $value) {
        if (isset($this->key)) {
            $this->$key = $value;
        } elseif (isset($this->object)) {
            $this->object->$key = $value;
        }
    }

    /**
     * Save function to DB
     */
    public function save($id = 0) {
        
        if($id)
        {

        }
        else
        {
            $key = [];
            $val = [];
            $_val = [];
            $lmark = [];
            $insrt = [];
    
            foreach ($this->object as $k => $v) {
                $key[] = "`" . $k . "`";
                $val[] = $v;
                $_val[] = ":" . $k;                 //create arr for values like :key
                $insrt[":" . $k] = $v;              //create arr for execute [:key] => val
            }
    
            $key = implode(",", $key);
            $_val = implode(",", $_val);
    
            try {
                self::_instance();
                $stmt = self::$db->prepare("INSERT INTO `" . $this::$table . "` (" . $key . ") VALUES (" . $_val . ")");
                $stmt->execute($insrt);
            } catch(\PDOException $ex) 
            {
                var_dump($ex->getMessage());die;
            }
        }
    }

    /**
     * Get all data from table
     * @param string $field
     * @param string $orderBy
     * @return mixed
     */
    public function all($field = null ,$orderBy = 'ASC'){
        
        $sql = "SELECT * FROM `". $this::$table .  "`";
        
        if ($field != NULL) {
            $sql .= ' ORDER BY `' . $this::$table . '`.' . '`' . $field . '` ' . $orderBy;
        }
        else
        {
            $sql .= ' ORDER BY `' . $this::$table . '`.' . '`id` ' . $orderBy;
        }

        try {
            self::_instance();
            //$stmt = self::$db->prepare("SELECT * FROM `" . $this::$table . "` ORDER BY " . $orderBy[0] . " " . $orderBy[1] . "\"");
            $stmt = self::$db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(\PDOException $ex) 
        {
            var_dump($ex->getMessage());die;
        }
    }

    public function get() {
        $args = func_get_args();
        $_select = $this->_parseSelect($this->_options);
        $_from = "FROM `" . $this::$table . "`";

        try {
            self::_instance();
            $stmt = self::$db->prepare($_select . $_from);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(\PDOException $ex) 
        {
            var_dump($ex->getMessage());die;
        }
    
    }

    private function _parseSelect($params){
        if (isset($params['select']) && $params['select']){
            $sql='SELECT ';
            foreach($params['select']['fields'] as $field) {
                $sql .= "`" . $field . "`,";
            }
            $sql = substr($sql, 0, strlen($sql) - 1) . " ";
        }
        else
        {
            $sql = "SELECT * ";
        }
        return $sql;
    }

    /**
     * Select fields from DB
     * @return mixed
     */
    public function select(){
        $args = func_get_args();

        if (count($args) == 1 && !is_array($args[0])){
            $this->_options['select']['fields'][] = $args[0];
        } elseif (isset($args[0]) && is_array($args[0])){
            foreach($args[0] as $field){
                $this->_options['select']['fields'][] = $field;
            }
        } else { $this->_options; }
        return $this;
    }
}