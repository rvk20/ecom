<?php

function redirect(string $url): void {
    header('Location: ' . $url, true, 303);
    exit;
}
function cryptPassword(string $password): string {
    return password_hash($password, PASSWORD_BCRYPT);
}

function isLogged(): bool {
    session_start();
    if(isset($_SESSION['user']))
        return true;
    else
        return false;
}

function isAdmin(): bool {
    session_start();
    if("admin" === $_SESSION['role'])
        return true;
    else
        return false;
}

function findCartElement($array, $id) {
    $element = 0;
    foreach ($array as $c) {
        if($c['id'] === $id) {
            return $element;
        }
        $element++;
    }
    return false;
}

function randomValue():int {
    return 1000*rand(1, 10000);
}