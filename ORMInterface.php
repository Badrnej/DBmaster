<?php
interface ORMInterface
{
    public function save();
    public function update();
    public function delete();
    public static function find($id);
    public static function all();
    public static function dropTable();
}
?>