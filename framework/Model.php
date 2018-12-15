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
            if(is_object($id))
            {
                $this->$object = $id;
                $this->$id = $this->$object->id;
            }
            else
            {
                $this->id = $id;

                self::_instance();
                $tab = $this::$table;
                $stmt = $this->db()->prepare("SELECT * FROM $tab WHERE id = :_id");
                $stmt->execute([':_id' => $this->id]);

                $this->object = $stmt->fetchObject();

                if (!isset($this->object->id))
                {
                    return false;
                }
            }
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
     * @param string $orderBy
     * @param string $field
     * @return mixed
     */
    public function all($orderBy = 'ASC', $field = null){
        
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
            $stmt = self::$db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(\PDOException $ex) 
        {
            var_dump($ex->getMessage());die;
        }
    }

    /**
     * Get data from DB
     */
    public function get() {
        $args = func_get_args();
        $_select = $this->_parseSelect($this->_options);
        $_where = $this->_parseWhere($this->_options);
        $_orderBy = $this->_parseOrderBy($this->_options);
        $_from = "FROM `" . $this::$table . "`";

        try {
            self::_instance();
            $stmt = self::$db->prepare($_select . $_from . $_where . $_orderBy);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(\PDOException $ex) 
        {
            var_dump($ex->getMessage());die;
        }
    
    }

    /**
     * Create part of sql select
     */
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
     * Create part of sql text where
     */
    private function _parseWhere($params){

        if (isset($params['where']) && count($params['where']) > 0) {
            if (count($params['where']) == 1) {
                $field = $params['where'][0]['field'];
                $action = $params['where'][0]['action'];
                $value = $params['where'][0]['value'];
                $sql = "WHERE `" . $this::$table . "`.`" . $field . "` " . $action . " " . $value;
            }
            else
            {
                $first = true;
                $_sql = " WHERE ";
                $sql = "";
                $isOR = false;
                foreach($params['where'] as $item) {
                    if (!isset($item['main_action']) && $item != "OR") {
                        $field = $item['field'];
                        $action = $item['action'];
                        $value = $item['value'];
                        if ($first)
                        {
                            $sql .= "`" . $this::$table . "`.`" . $field . "` " . $action . " " . $value;
                            $first = false;
                        }
                        else
                        {
                            $sql .= " AND `" . $this::$table . "`.`" . $field . "` " . $action . " " . $value;
                        }
                    }
                    elseif($item == "OR") {
                        $sql = "(" . $sql . ") OR (";
                        $first = true;
                        $isOR = true;
                    }
                }
            }        
            $sql = $_sql . $sql;
            if ($isOR){
                $sql .= ")";
            }

            return $sql;
        }
    }

    /**
     * Create part of sql orderBy
     */
    private function _parseOrderBy($params) {
        $sql = "";
        if (isset($params['orderBy']) && count($params['orderBy']) > 0) {
            $sql = ' ORDER BY `' . $this::$table . '`.`' . $params['orderBy']['field'] . '` ' . $params['orderBy']['action'];
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

    /**
     * Make configuration where
     */
    public function where(){
        $args = func_get_args();

        if (count($args) > 1 && !is_array($args[0])){
            $res = count($args);
            switch($res){
                case 2:
                    $this->_options['where'][] = ['field' => $args[0], 'action' => '=', 'value' => $args[1]];
                    break;
                case 3:
                    if ($args[1] != '>' && $args[1] != '<' && $args[1] != '=' && $args[1] != '!=' && $args[1] != '>=' && $args[1] != '<=' ) {
                        $args[1] = strtoupper($args[1]);
                    }
                    $this->_options['where'][] = ['field' => $args[0], 'action' => $args[1], 'value' => $args[2]];
                    break;    
            }
        } else if (count($args) == 1) {
            $this->_options['where'][] = ['field' => 'id', 'action' => '=', 'value' => $args[0]];
        }

        return $this;
    }


    /**
     * Make configuration whereOR
     */
    public function whereOR(){
        if (isset($this->_options['where'][0])) {
            $this->_options['where']['main_action'] = 'OR';
        }
        return $this;
    }

    /**
     * Make configuration ORDER BY
     */
    public function orderBy(){
        $args = func_get_args();
        $field = 'id';
        $keyword = 'ASC';
        if (isset($args))
        {
            if (count($args) == 2) {
                $field = $args[0];
                $keyword = $args[1];
            }
            elseif(count($args) == 1) {
                $keyword = $args[0];
            }
        }
        $this->_options['orderBy'] = ['field' => $field, 'action' => $keyword];
        return $this;
    }
}