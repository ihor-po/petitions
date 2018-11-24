<?php

namespace Framework;

use PDO;

abstract class Model
{
    static protected $db;

    protected static function DB()
    {
        if (null === static::$db) {
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
    public  static function exist($table) : bool
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
     * Проверка существования подключения
     */
    protected static function _instance()
    {
        if (static::$db == null)
        {
            static::DB();
        }
    }
}