<?php
namespace App\models;

use App\services\DB;

/**
 * Class Model
 * @property $id
 */
abstract class Model
{
    /**
     * @var DB
     */
    protected $db;

    abstract protected static function getTableName():string ;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->db = static::getDB();
    }

    /**
     * @return DB
     */
    protected static function getDB()
    {
        return DB::getInstance();
    }

    public static function getOne($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return static::getDB()->findObject($sql, static::class, [':id' => $id]);
    }

    public static function getAll()
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return static::getDB()->findObjects($sql, static::class);
    }

    protected function insert()
    {
        $columns = [];
        $params = [];
        foreach ($this as $key => $value) {
            if ($key === 'db') {
                continue;
            }
            $columns[] = $key;
            $params[":{$key}"] = $value;
        }

        $tableName = $this->getTableName();
        $fields = implode(',', $columns);
        $placeholders = implode(',', array_keys($params));
        $sql = "INSERT INTO {$tableName} ({$fields}) VALUES ($placeholders)";
        $this->db->execute($sql, $params);

        $this->id = $this->db->lastInsertId();
    }

    protected function update()
    {
        $columns = [];
        $params = [];
        
        foreach ($this as $key => $value) {
            if ($key === 'db' OR $key === 'id') {
                continue;
            }
            
            $columns[] = "$key = :$key";
            $params[$key] = $value;
        }

        $tableName = $this->getTableName();
        $fields = implode(',', $columns);
        $sql = "UPDATE $tableName SET $fields WHERE id = {$this->id};";
        $this->db->execute($sql, $params);
    }

    public function delete()
    {
        $sql = "DELETE FROM {$this->getTableName()} WHERE id = :id";
        $this->db->execute($sql, [':id' => $this->id]);
    }

    public function save()
    {
        if (!$this->id) {
            $this->insert();
            return;
        }

        $this->update();
    }
}