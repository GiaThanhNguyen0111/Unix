<?php

require __DIR__ . "/config/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = explode( '/', $uri );

if ((isset($uri[2]) && $uri[2] != 'customer') || !isset($uri[3])) {

    header("HTTP/1.1 404 Not Found");

    exit();

}

require PROJECT_ROOT_PATH . "/controller/api/CustomerController.php";

$objFeedController = new CustomerController();

$strMethodName = $uri[3] . 'Action';

$objFeedController->{$strMethodName}();

require PROJECT_ROOT_PATH . "/controller/api/OrderController.php";

$objFeedController = new OrderController();

$strMethodName = $uri[3] . 'Action';

$objFeedController->{$strMethodName}();

require PROJECT_ROOT_PATH . "/controller/api/ProductController.php";

$objFeedController = new ProductController();

$strMethodName = $uri[3] . 'Action';

$objFeedController->{$strMethodName}();

require PROJECT_ROOT_PATH . "/controller/api/StoreController.php";

$objFeedController = new StoreController();

$strMethodName = $uri[3] . 'Action';

$objFeedController->{$strMethodName}();

?>



