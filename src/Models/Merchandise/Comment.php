<?php
namespace App\Model\Merchandise;

use App\Core\Database;
use PDO;

class Comment extends Database
{
    public static function create($author, $text, $product): void {
        $db = Database::conDb();
        $stmt = $db->prepare("INSERT INTO comment (`author`, `text`, `product`) VALUES(:author, :text, :product);");
        $stmt -> bindParam(":author", $author, PDO::PARAM_INT);
        $stmt -> bindParam(":text", $text, PDO::PARAM_STR);
        $stmt -> bindParam(":product", $product, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function fetchByProduct($id) {
        $db = Database::conDb();
        $sql = "SELECT c.id, (SELECT name FROM user WHERE id = c.author) as author, c.text, c.product FROM comment c WHERE c.product = :id ORDER BY c.id DESC;";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }
}