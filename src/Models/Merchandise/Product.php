<?php
namespace App\Model\Merchandise;

use App\Core\Database;
use PDO;

class Product extends Database {
    private int $id;
    private string $name;
    private float $cost;
    private int $quantity;
    private int $category;
    private int $image;

    public function __construct(string $name, float $cost, int $quantity, int $category, int $image) {
        $this->name = $name;
        $this->cost = $cost;
        $this->quantity = $quantity;
        $this->category = $category;
        $this->image = $image;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setCost($cost): void {
        $this->cost = $cost;
    }

    public function getCost(): float {
        return $this->cost;
    }

    public function setQuantity($quantity): void {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setCategory($category): void {
        $this->category = $category;
    }

    public function getCategory(): int {
        return $this->category;
    }

    public function setImage($image): void {
        $this->image = $image;
    }

    public function getImage(): int {
        return $this->image;
    }

    public function create(): bool {
        $db = Database::conDb();
        $stmt = $db->prepare("INSERT INTO product (`name`, `cost`, `quantity`, `category`, `image`) VALUES(:name, :cost, :quantity, :category, :image)");
        $stmt -> bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt -> bindParam(":cost", $this->cost, PDO::PARAM_STR);
        $stmt -> bindParam(":quantity", $this->quantity, PDO::PARAM_INT);
        $stmt -> bindParam(":category", $this->category, PDO::PARAM_INT);
        $stmt -> bindParam(":image", $this->image, PDO::PARAM_INT);
        $stmt->execute();
        $this->setId($db->lastInsertId());
        return true;
    }

    public function update(): bool {
        $db = Database::conDb();
        $stmt = $db->prepare("UPDATE product SET `name` = :name, `cost` = :cost, `quantity` = :quantity, `category` = :category, `image` = :image WHERE id = :id");
        $stmt -> bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt -> bindParam(":cost", $this->cost, PDO::PARAM_STR);
        $stmt -> bindParam(":quantity", $this->quantity, PDO::PARAM_INT);
        $stmt -> bindParam(":category", $this->category, PDO::PARAM_INT);
        $stmt -> bindParam(":image", $this->image, PDO::PARAM_INT);
        $stmt -> bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

    public static function deleteById($id): bool {
        $db = Database::conDb();
        $stmt = $db->prepare("DELETE FROM product WHERE id = :id");
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

    public static function getOneById($id): self {
        $db = Database::conDb();
        $sql = "SELECT * FROM `product` WHERE `id` = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $value = $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
        $product = new Product($value->name, $value->cost, $value->quantity, $value->category, $value->image);
        $product->setId($id);
        return $product;
    }

    public static function fetchOneById($id) {
        $db = Database::conDb();
        $sql = "SELECT p.id, p.name, p.cost, p.quantity, p.category, (SELECT filename FROM file WHERE `id` = p.image) as image FROM `product` p WHERE `id` = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
        return $product;
    }

    public static function fetchById($id) {
        $db = Database::conDb();
        $sql = "SELECT p.id, p.name, p.cost, p.quantity, p.category, (SELECT filename FROM file WHERE `id` = p.image) as image FROM `product` p WHERE `category` = :id";
        $stmt = $db->prepare($sql);
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }

    public static function fetchAll() {
        $db = Database::conDb();
        $sql = "SELECT * FROM `product`";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }
}