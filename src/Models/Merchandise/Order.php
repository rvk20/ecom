<?php
namespace App\Model\Merchandise;

use App\Core\Database;
use PDO;

class Order extends Database
{
    private string $name;
    private float $cost;
    private string $status;
    private int $user;
    private string $date;

    public function __construct($name, $cost, $user) {
        $this->name = $name;
        $this->cost = $cost;
        $this->status = "Złożone";
        $this->user = $user;
        $this->date = date('Y-m-d H:i:s');
    }

    public function create($product) {
        $db = Database::conDb();
        $stmt = $db->prepare("START TRANSACTION;");
        $stmt->execute();
        $stmt = $db->prepare("INSERT INTO ord (`name`, `cost`, `status`, `user`, `date`) VALUES(:name, :cost, :status, :user, :date);");
        $stmt -> bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt -> bindParam(":cost", $this->cost, PDO::PARAM_STR);
        $stmt -> bindParam(":status", $this->status, PDO::PARAM_STR);
        $stmt -> bindParam(":user", $this->user, PDO::PARAM_INT);
        $stmt -> bindParam(":date", $this->date, PDO::PARAM_STR);
        $stmt->execute();
        $id = $db->lastInsertId();
        foreach ($product as $p) {
            $stmt = $db->prepare("INSERT INTO ord_item (`product`, `quantity`, `ord`) VALUES(:product, :quantity, :ord);");
            $stmt -> bindParam(":product", $p->id, PDO::PARAM_STR);
            $stmt -> bindParam(":quantity", $p->quantity, PDO::PARAM_INT);
            $stmt -> bindParam(":ord", $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        $stmt = $db->prepare("COMMIT;");
        $stmt->execute();
    }

    public static function fetchByStatus($status) {
        $db = Database::conDb();
        if(null!==$status)
            $sql = "SELECT o.id, o.name, o.cost, o.status, (SELECT name FROM user WHERE id = o.user) as user, o.date FROM ord o WHERE o.status = :status";
        else
            $sql = "SELECT * FROM ord o";
        $stmt = $db->prepare($sql);
        $stmt -> bindParam(":status", $status, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }

    public static function fetchById($id) {
        $db = Database::conDb();
        $sql = "SELECT o.id, o.name, o.cost, o.status, o.date FROM ord o WHERE o.user = :id";
        $stmt = $db->prepare($sql);
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }

    public static function fetchItems($id) {
        $db = Database::conDb();
        $sql = "SELECT (SELECT name FROM product WHERE id = o.product) as product, quantity FROM ord_item o WHERE o.ord = :id";
        $stmt = $db->prepare($sql);
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }

    public static function changeStatus($status, $id) {
        $date = date('Y-m-d H:i:s');
        $db = Database::conDb();
        $sql = "UPDATE ord SET status = :status, date = :date WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
        $stmt -> bindParam(":status", $status, PDO::PARAM_STR);
        $stmt -> bindParam(":date", $date , PDO::PARAM_STR);
        $stmt->execute();
    }
}