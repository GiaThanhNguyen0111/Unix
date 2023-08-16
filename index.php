<?php

require __DIR__ . "/config/bootstrap.php";
require PROJECT_ROOT_PATH . "/controller/api/ProductController.php";
require PROJECT_ROOT_PATH . "/controller/api/CustomerController.php";
require PROJECT_ROOT_PATH . "/controller/api/OrderController.php";
require PROJECT_ROOT_PATH . "/controller/api/StoreController.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = explode( '/', $uri );

if (!(isset($uri[2]))) {

    header("HTTP/1.1 404 Not Found");

    exit();
}


if ($uri[2] == "customer") {
    // CustomerController
    $objFeedController = new CustomerController();
    
    $strMethodName = $uri[3] . 'Action';
    
    $objFeedController->{$strMethodName}();
} elseif ($uri[2] == "order") {
    // Order Controller
    $objFeedController = new OrderController();
    
    $strMethodName = $uri[3] . 'Action';
    
    $objFeedController->{$strMethodName}();
} elseif ($uri[2] == "product") {
    // Product Controller
    $objFeedController = new ProductController();
    
    $strMethodName = $uri[3] . 'Action';
    
    $objFeedController->{$strMethodName}();
} elseif ($uri[2] == "store") {
    //Store Controller
    $objFeedController = new StoreController();
    
    $strMethodName = $uri[3] . 'Action';
    
    $objFeedController->{$strMethodName}();
}


?>



