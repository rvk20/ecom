<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

abstract class Database {
    public static function conDb(): ?PDO
    {
        static $db = null;
        $host = "localhost";
        $user = "root";
        $password = "password";
        $name = "ecom";

        if ($db === null) {
            try {
                $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";
                $db = new PDO($dsn, $user, $password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $error){
                echo 'Database connection error';
            }
        }
        return $db;
    }
}