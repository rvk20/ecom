<?php
namespace App\Controller\Merchandise;

use App\Model\Merchandise\Cart;
use App\Model\Merchandise\Order;
use App\Model\Merchandise\Product;

class Carts
{
    public function addToCart() {
        $cart = new Cart();
        $element = false;
        $quantity = $_POST['quantity'];
        if($_SESSION['cart'])
            $element = findCartElement($_SESSION['cart'], $_POST['id']);
        if($element)
            $quantity += $_SESSION['cart'][$element]['quantity'];
        $product = Product::getOneById($_POST['id']);
        if(0 === $product->getQuantity())
            redirect("/shop?c=" . $_POST['param']);
        if($product->getQuantity() <= $quantity) {
            Cart::removeFromCart($_POST['id']);
            $cart->addToCart($_POST['id'], $product->getQuantity(), $_POST['cost'], $_POST['name'], $_POST['img']);
        }
        else
            $cart->addToCart($_POST['id'], $_POST['quantity'], $_POST['cost'], $_POST['name'], $_POST['img']);

        redirect("/shop?c=" . $_POST['param']);
    }

    public function removeFromCart() {
        Cart::removeFromCart($_POST['id']);
    }

    public function getCart() {
        echo json_encode(Cart::fetchCart());
    }

    public function addOrder() {
        $order = new Order($_SESSION['user'] . randomValue(),$_POST['cost'],$_SESSION['user']);
        $order->create(json_decode($_POST['product']));
        Cart::empty();
        redirect("/shop");
    }

    public function getOrders($status) {
        echo json_encode(Order::fetchByStatus($status));
    }

    public function getOrdersById() {
        echo json_encode(Order::fetchById($_SESSION['user']));
    }

    public function getItems($id) {
        echo json_encode(Order::fetchItems($id));
    }

    public function changeStatus() {
        Order::changeStatus($_POST['status'], $_POST['id']);
        redirect("/admin/orders");
    }
}