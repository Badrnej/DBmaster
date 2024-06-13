<?php
require_once 'ORM.php';

class Product extends ORM
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $attributes = [
        'id' => null,
        'name' => '',
        'price' => 0.0,
        'created_at' => '',
        'updated_at' => ''
    ];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }

    public function getAttribute($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function save()
    {
        try {
            return parent::save();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // SQLSTATE code for unique constraint violation
                echo "Error: Duplicate entry for key 'name'.";
            } else {
                throw $e;
            }
        }
        return false;
    }

    public function update()
    {
        return parent::update();
    }

    public function delete()
    {
        $db = Database::getInstance()->getConnection();
        // Delete related orders
        $stmt = $db->prepare("DELETE FROM orders WHERE product_id = ?");
        $stmt->execute([$this->attributes[$this->primaryKey]]);
        return parent::delete();
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
    public static function reorganizeIds()
    {
        $db = Database::getInstance()->getConnection();
        $sql = "SET @count = 0;
                UPDATE products SET id = @count:= @count + 1;
                ALTER TABLE products AUTO_INCREMENT = 1;";
        $stmt = $db->prepare($sql);
        return $stmt->execute();
    }

}

?>