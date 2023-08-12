<?php
    define("PROJECT_ROOT_PATH", __DIR__ . "/..");

    require_once PROJECT_ROOT_PATH . "/config/config.php";

    require_once PROJECT_ROOT_PATH . "/controller/api/BaseController.php";

    require_once PROJECT_ROOT_PATH . "/model/CustomerModel.php";

    require_once PROJECT_ROOT_PATH . "/model/OrderModel.php";

    require_once PROJECT_ROOT_PATH . "/model/ProductModel.php";

    require_once PROJECT_ROOT_PATH . "/model/StoreModel.php";

    require_once PROJECT_ROOT_PATH . "/model/OrderProductModel.php";
?>