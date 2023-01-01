<?php
declare(strict_types=1);

namespace App\Config;

use App\Controller\Merchandise\Carts;
use App\Controller\Merchandise\Categories;
use App\Controller\Merchandise\Products;
use App\Core\Router;
use App\Controller\Auth\Auth;

$router = new Router();

if(isLogged()) {
    $router->get('/admin/orders/get/items', function () {
        $carts = new Carts();
        $carts->getItems($_GET['o']);
    });

    $router->get('/logout', function () {
        $auth = new Auth();
        $auth->logout();
    });

    $router->get('/user/data', function () {
        $auth = new Auth();
        $auth->getUser();
    });

    if(isAdmin()) {
        $router->get('/', function () {
            redirect("/admin/categories");
        });

        $router->post('/admin/product/update', function () {
            $products = new Products();
            $products->updateProduct($_GET['p']);
        });

        $router->post('/admin/product/delete', function () {
            $products = new Products();
            $products->deleteProduct($_GET['p']);
        });

        $router->post('/admin/product/create/add', function () {
            $products = new Products();
            $products->createProduct();
        });

        $router->get('/admin/categories', function () {
            require("Templates/Merchandise/Admin/category.html");
        });

        $router->get('/admin/product', function () {
            require("Templates/Merchandise/Admin/product.html");
        });

        $router->get('/admin/product/create', function () {
            require("Templates/Merchandise/Admin/create_product.html");
        });

        $router->get('/admin/orders', function () {
            require("Templates/Merchandise/Admin/order.html");
        });

        $router->get('/admin/orders/items', function () {
            require("Templates/Merchandise/Admin/item.html");
        });

        $router->get('/admin/orders/get/all', function () {
            $carts = new Carts();
            $carts->getOrders($_GET['o']);
        });

        $router->post('/admin/orders/set/items', function () {
            $carts = new Carts();
            $carts->changeStatus();
        });
    }
    else {
        $router->get('/shop', function () {
            require("Templates/Merchandise/User/shop.html");
        });

        $router->get('/cart', function () {
            require("Templates/Merchandise/User/cart.html");
        });

        $router->get('/history', function () {
            require("Templates/Merchandise/User/history.html");
        });

        $router->get('/shop/getcart', function () {
            $carts = new Carts();
            $carts->getCart();
        });

        $router->get('/history/get/all', function () {
            $carts = new Carts();
            $carts->getOrdersById();
        });

        $router->get('/', function () {
            redirect("/shop?c=1");
        });

        $router->post('/product/comment/add', function () {
            $products = new Products();
            $products->addComment();
        });

        $router->post('/shop/addtocart', function () {
            $carts = new Carts();
            $carts->addToCart();
        });

        $router->post('/cart/remove', function () {
            $carts = new Carts();
            $carts->removeFromCart();
        });

        $router->post('/cart/addorder', function () {
            $carts = new Carts();
            $carts->addOrder();
        });
    }
}
else {
    $router->get('/', function () {
        redirect("/login");
    });

    $router->get('/login', function () {
        require("Templates/Auth/main.html");
    });

    $router->get('/register', function () {
        require("Templates/Auth/register.html");
    });

    $router->post('/auth', function () {
        $auth = new Auth();
        $auth->login();
    });

    $router->post('/new/user', function () {
        $auth = new Auth();
        $auth->create();
    });
}

$router->addNotFound(function () {
    echo 'Strona nie istnieje';
});

$router->get('/categories/fetch_all', function () {
    $categories = new Categories();
    $categories->getCategories();
});

$router->get('/products/fetch_all', function () {
    $products = new Products();
    $products->getProductsById($_GET['c']);
});

$router->get('/products/product', function () {
    $products = new Products();
    $products->getProduct($_GET['p']);
});

$router->get('/product/comment', function () {
    $products = new Products();
    $products->getComments($_GET['p']);
});

$router->run();