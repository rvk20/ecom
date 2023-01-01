<?php
namespace App\Model\Merchandise;

use App\Core\Database;
use PDO;

class Category extends Database {
    private int $id;
    private string $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function create(): bool {
        $db = Database::conDb();
        $stmt = $db->prepare("INSERT INTO category (`name`) VALUES(:name)");
        $stmt -> bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->execute();
        $this->setId($db->lastInsertId());
        return true;
    }

    public static function delete($id): bool {
        $db = Database::conDb();
        $stmt = $db->prepare("DELETE category WHERE `id` = :id");
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

    public static function fetchAll() {
        $db = Database::conDb();
        $sql = "SELECT * FROM `category`";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }
}