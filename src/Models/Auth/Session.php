<?php
namespace App\Models\Auth;

//require ("../../../vendor/autoload.php");

use App\Core\Database;
use PDO;

class Session extends Database
{
    public function __construct(int $user, string $role) {
        session_start();
        session_regenerate_id(true);
        $_SESSION['id'] = session_id();
        $_SESSION['user'] = $user;
        $_SESSION['role'] = $role;
        $_SESSION['started_at'] = date('Y-m-d H:i:s');
    }

    public function registerStart(): void {
        $db = Database::conDb();
        $stmt = $db->prepare("INSERT INTO `session` (`session_id`, `user_id`, `role`, `started_at`) VALUES(:id, :user, :role, :started_at)");
        $stmt->bindValue(':id', $_SESSION['id'], \PDO::PARAM_STR);
        $stmt->bindValue(':user', $_SESSION['user'], \PDO::PARAM_INT);
        $stmt->bindValue(':role', $_SESSION['role'], \PDO::PARAM_STR);
        $stmt->bindValue(':started_at', $_SESSION['started_at'], \PDO::PARAM_STR);
        $stmt->execute();
    }

    public static function fetchUser() {
        $db = Database::conDb();
        $stmt = $db->prepare("SELECT * FROM user WHERE `id` = :id");
        $stmt->bindValue(':id', $_SESSION['user'], \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
    }

    public static function registerEnd(): void {
        session_start();
        $db = Database::conDb();
        $stmt = $db->prepare("UPDATE `session` SET `end` = :endtime, `status` = 0 WHERE `session_id` = :id");
        $stmt->bindValue(':endtime', date('Y-m-d H:i:s'), \PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['id'], \PDO::PARAM_STR);
        $stmt->execute();
    }

    public static function endSession(): void {
        self::registerEnd();
        $_SESSION = [];
        session_destroy();
    }
}