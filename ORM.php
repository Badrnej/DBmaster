<?php
require_once 'ORMInterface.php';
require_once 'Database.php';

abstract class ORM implements ORMInterface
{
    protected $table;
    protected $primaryKey = 'id';
    protected $attributes = [];

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function save()
    {
        $db = Database::getInstance()->getConnection();
        $columns = implode(',', array_keys($this->attributes));
        $placeholders = implode(',', array_fill(0, count($this->attributes), '?'));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $db->prepare($sql);
        return $stmt->execute(array_values($this->attributes));
    }

    public function update()
    {
        $db = Database::getInstance()->getConnection();
        if (!isset($this->attributes[$this->primaryKey])) {
            throw new Exception("Primary key not set.");
        }
        $set = '';
        foreach ($this->attributes as $key => $value) {
            $set .= "{$key} = ?,";
        }
        $set = rtrim($set, ',');
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = ?";
        $stmt = $db->prepare($sql);
        $values = array_values($this->attributes);
        $values[] = $this->attributes[$this->primaryKey];
        return $stmt->execute($values);
    }

    public function delete()
    {
        $db = Database::getInstance()->getConnection();
        if (!isset($this->attributes[$this->primaryKey])) {
            throw new Exception("Primary key not set.");
        }
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$this->attributes[$this->primaryKey]]);
    }

    public static function find($id)
    {
        $db = Database::getInstance()->getConnection();
        $instance = new static;
        $sql = "SELECT * FROM {$instance->table} WHERE {$instance->primaryKey} = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $instance->attributes = $result;
        }
        return $result ? $instance : null;
    }

    public static function all()
    {
        $db = Database::getInstance()->getConnection();
        $instance = new static;
        $sql = "SELECT * FROM {$instance->table}";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function dropTable()
    {
        $db = Database::getInstance()->getConnection();
        $instance = new static;
        $sql = "DROP TABLE IF EXISTS {$instance->table}";
        $stmt = $db->prepare($sql);
        return $stmt->execute();
    }
}

?>