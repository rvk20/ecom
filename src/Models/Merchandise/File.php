<?php
namespace App\Model\Merchandise;

use App\Core\Database;
use PDO;

class File extends Database {
    private int $id;
    private string $filename;

    public function __construct($filename) {
        $this->filename = $filename;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function create(): bool {
        $db = Database::conDb();
        $stmt = $db->prepare("INSERT INTO file (`filename`) VALUES(:filename)");
        $stmt -> bindParam(":filename", $this->filename, PDO::PARAM_STR);
        $stmt->execute();
        $this->setId($db->lastInsertId());
        return true;
    }

    public function update(): bool {
        $db = Database::conDb();
        $stmt = $db->prepare("UPDATE file SET `filename` = :filename WHERE id = :id");
        $stmt -> bindParam(":filename", $this->filename, PDO::PARAM_STR);
        $stmt -> bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

    public static function getOneById($id): self {
        $db = Database::conDb();
        $sql = "SELECT * FROM `file` WHERE `id` = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $value = $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
        $file = new File($value->filename);
        $file->setId($id);
        return $file;
    }

    public static function getLastId(): int {
        try {
            $db = Database::conDb();
            $sql = "SELECT max(id) AS id FROM file";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $value = $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
            return $value->id;
        } catch (\PDOException $exception) {
            return 1;
        }

    }
}