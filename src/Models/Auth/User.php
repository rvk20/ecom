<?php
declare(strict_types=1);

namespace App\Models\Auth;

//include ("../../../vendor/autoload.php");

use App\Core\Database;
use PDO;

class User extends Database
{
    private string $name;
    private string $password;
    private string $role;

    public function __construct(string $name, string $password, string $role) {
        $this->name = $name;
        $this->password = $password;
        $this->role = $role;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setRole($role): void {
        $this->role = $role;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function create() {
        $db = Database::conDb();
        $stmt = $db->prepare("INSERT INTO user (name, password, role) VALUES(:name, :password, :role)");
        $stmt -> bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt -> bindParam(":password", cryptPassword($this->password), PDO::PARAM_STR);
        $stmt -> bindParam(":role", $this->role, PDO::PARAM_STR);
        $stmt->execute();
    }

    public static function findByName(string $name) {
        $db = Database::conDb();
        $stmt = $db->prepare("SELECT * FROM `user` WHERE `name` = :name");
        $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
    }

    public static function isUserInDatabase(string $name): bool {
        $db = Database::conDb();
        $stmt = $db->prepare("SELECT * FROM `user` WHERE `name` = :name");
        $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
        $stmt->execute();
        return !!($stmt->fetch(\PDO::FETCH_OBJ));
    }
}