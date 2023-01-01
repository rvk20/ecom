<?php
namespace App\Controller\Merchandise;

use App\Model\Merchandise\Comment;
use App\Model\Merchandise\File;
use App\Model\Merchandise\Product;

class Products
{
    public function getProducts() {
        echo json_encode(Product::fetchAll());
    }

    public function getProductsById($id) {
        echo json_encode(Product::fetchById($id));
    }

    public function getProduct($id) {
        echo json_encode(Product::fetchOneById($id));
    }

    public function updateProduct($id) {
        $product = Product::getOneById($id);
        $product->setName($_POST['name']);
        $product->setCost($_POST['cost']);
        $product->setCategory($_POST['category']);
        $product->setQuantity($_POST['quantity']);
        if(isset($_FILES)) {
            $filename = self::createImage($_FILES['img']['name'], $_FILES['img']['tmp_name']);
            if($filename) {
                $file = new File($filename);
                $file->create();
                $product->setImage(File::getLastId());
            }
        }
        $product->update();
        redirect("/admin/categories");
    }

    public function createProduct() {
        $filename = self::createImage($_FILES['img']['name'], $_FILES['img']['tmp_name']);
        if($filename) {
            $file = new File($filename);
            if($file->create()) {
                $product = new Product($_POST['name'], $_POST['cost'], $_POST['quantity'], $_POST['categories'], File::getLastId());
                $product->create();
                redirect("/admin/product/create");
            }
        }
    }

    public function deleteProduct($id) {
        Product::deleteById($id);
        redirect("/admin/categories");
    }

    public static function createImage($name, $tmp_name) {
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $filename = md5($name . (File::getLastId()+1)) . "." . $extension;
        $folder = "images/";
        if(move_uploaded_file($tmp_name,$folder . $filename))
            return $filename;
        else
            return null;
    }

    public function addComment() {
        Comment::create($_POST['author'], $_POST['text'], $_POST['product']);
    }

    public function getComments($id) {
        echo json_encode(Comment::fetchByProduct($id));
    }
}