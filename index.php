<?php

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

use Bramus\Router\Router;
use App\Controllers\ProductController;
// Create Router instance
$router = new Router();
$productController = new ProductController();

// Define routes
$router->get('/', function () {
    echo 'Test';
});

$router->get('/products', function () use ($productController) {
    $result = $productController->getAllProducts();
    header('Content-Type: application/json');
    $data = json_encode($result);
    echo $data;
});

$router->get('/product/{id}', function (int $id) use ($productController) {

    $result = $productController->getByIdProducts($id);
    header('Content-Type: application/json');
    $data = json_encode($result);
    echo $data;
});


$router->get('/products/search', function () use ($productController) {
    $limit = $_GET['limit'] ?? 10;
    $skip = $_GET['skip'] ?? 0;
    $sortBy = $_GET['sortBy'] ?? 'id';
    $order = $_GET['order'] ?? 'asc';

    $result = $productController->searchProducts($limit, $skip, $sortBy, $order);
    header('Content-Type: application/json');
    $data = json_encode($result);

    echo $data;
});


// Run it!
$router->run();
