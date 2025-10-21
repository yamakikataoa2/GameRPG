<?php
class DB
{
    private static $instance = NULL;
    //Khai báo phương thức static, khi sử dụng phải thông qua tên lớp.
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO('mysql:host=localhost;dbname=gamerpg', 'root', '');
                self::$instance->exec("SET NAMES 'utf8'");
            } catch (PDOException $ex) {
                die($ex->getMessage());
            }
        }
        return self::$instance;
    }
}
?>