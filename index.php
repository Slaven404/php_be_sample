<?php

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

use Bramus\Router\Router;
use App\Controllers\ProductController;

$router = new Router();
$productController = new ProductController();

// Define routes
$router->get('/', function () {
    echo 'Live!';
});

$router->get('/products', function () use ($productController) {
    $result = $productController->getAllProducts();

    header('Content-Type: application/json');
    echo json_encode($result);
});

$router->get('/products/search', function () use ($productController) {
    $limit = $_GET['limit'] ?? 10;
    $skip = $_GET['skip'] ?? 0;
    $sortBy = $_GET['sortBy'] ?? 'id';
    $order = $_GET['order'] ?? 'asc';

    $result = $productController->searchProducts($limit, $skip, $sortBy, $order);

    header('Content-Type: application/json');
    echo json_encode($result);

});

$router->get('/products/{id}', function (int $id) use ($productController) {
    $result = $productController->getByIdProducts($id);

    header('Content-Type: application/json');
    echo json_encode($result);
});





// Run it!
$router->run();
