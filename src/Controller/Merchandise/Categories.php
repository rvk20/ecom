<?php
namespace App\Controller\Merchandise;

use App\Model\Merchandise\Category;

class Categories
{
    public function getCategories() {
        echo json_encode(Category::fetchAll());
    }
}