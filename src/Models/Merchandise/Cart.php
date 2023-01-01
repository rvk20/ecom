<?php
namespace App\Model\Merchandise;

class Cart
{
    public function __construct() {
        if(!$_SESSION['cart']) {
            session_start();
            $_SESSION['cart'] = array();
        }
    }

    public function addToCart($id, int $quantity, float $cost, $name, $img) {
        session_start();
        $element = findCartElement($_SESSION['cart'], $id);
        if(false === $element)
            array_push($_SESSION['cart'], array('id' => $id, 'quantity' => $quantity, 'cost' => $cost, 'name' => $name, 'img' => $img));
        else
            $_SESSION['cart'][$element]['quantity'] += $quantity;
    }

    public static function removeFromCart($id) {
        $element = findCartElement($_SESSION['cart'], $id);
        if(false !== $element)
            array_splice($_SESSION['cart'], $element, 1);
    }

    public static function empty() {
        session_start();
        $_SESSION['cart'] = [];
    }

    public static function fetchCart() {
        session_start();
        return $_SESSION['cart'];
    }
}