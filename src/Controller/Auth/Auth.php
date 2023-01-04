<?php
namespace App\Controller\Auth;

use App\Models\Auth\User;
use App\Models\Auth\Session;

class Auth
{
    public function create(): void {
        if($this->validateRegister($_POST)){
            $user = new User($_POST['name'], $_POST['password'], "user");
            $user->create();
            redirect("/");
        }
        redirect("/register?v=e");
    }

    public function login(): void {
        if($this->validateLogin($_POST)) {
            $user = User::findByName($_POST['name']);
            $session = new Session($user->id, $user->role);
            $session->registerStart();
            redirect("/");
        }
        redirect("/login?v=f");
    }

    public function logout(): void {
        Session::endSession();
        redirect("/login");
    }

    private function validateLogin(array $data): bool {
        if (
            User::isUserInDatabase($data['name']) ||
            $this->credentialsAreCorrect($data['name'], cryptPassword($data['password']))
        )
            return true;
        else
            return false;
    }

    private function credentialsAreCorrect(string $name, string $password): bool {
        if(!User::findByName($name))
            return false;
        if($password===User::findByName($name)->getPassword())
            return true;
        else
            return false;
    }

    private function validateRegister(array $data): bool {
        if(User::isUserInDatabase($data['name']))
            return false;
        else
            return true;
    }

    public function getUser() {
        echo json_encode(Session::fetchUser());
    }
}
