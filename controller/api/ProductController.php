<?php
class ProductController extends BaseController {
    public function listAction() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();
        echo $arrQueryStringParams;
        if (strtoupper($requestMethod) == "GET") {
            try {
                $productModel = new ProductModel();

                $intLimit = 10;

                if (isset ($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }

                $arrOrder = $productModel -> getProducts($intLimit);
                $responseData = json_encode($arrOrder);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';

            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

        }
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')

            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function createProductAction() {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if ($requestMethod == "POST") {
            if (count($_POST)) {
                $productName = $_POST['product_name'];
                $storeId = $_POST['store_id'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
                try {
                    $productModel = new ProductModel();

                    $productModel->createProduct($storeId, $productName, $description, $price, $quantity);
                } catch (Error $e) {
                    $e -> getMessage();
                }
                
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

        }
        if (!$strErrorDesc) {
            $this->sendOutput(
                json_encode(array("isCreated" => true)),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')

            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc,
                                                "isCreated" => false)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
    }
    }
    public function updateProductAction () {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if ($requestMethod == "POST") {
            if (count($_POST)) {
                $productName = $_POST['product_name'];
                $storeId = $_POST['store_id'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
                $productId = $_POST['product_id'];

                try {
                    $productModel = new ProductModel();

                    $productModel->updateProductInfo($productId ,$storeId, $productName, $description, $price, $quantity);
                } catch (Error $e) {
                    $e -> getMessage();
                }
                
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

        }
        if (!$strErrorDesc) {
            $this->sendOutput(
                json_encode(array("isUpdated" => true)),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')

            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc,
                                                "isUpdated" => false)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function deleteProductAction () {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if ($requestMethod == "POST") {
            if (count($_POST)) {
                $productId = $_POST['product_id'];

                try {
                    $productModel = new ProductModel();

                    $result = $productModel->deleteProduct($productId);
                } catch (Error $e) {
                    $e -> getMessage();
                }
                
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

        }
        if (!$strErrorDesc) {
            $this->sendOutput(
                json_encode(array("isDeleted" => true)),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')

            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc,
                                                'isDeleted' => false)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function findByNameAction() {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if ($requestMethod == "POST") {
            if (count($_POST)) {
                $name = $_POST['product_name'];

                try {
                    $productModel = new ProductModel();

                    $result = $productModel->findByName($name);

                    $resBody = json_encode($result);
                } catch (Error $e) {
                    $e -> getMessage();
                }
                
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

        }
        if (!$strErrorDesc) {
            $this->sendOutput(
                $resBody,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')

            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function findByStoreAction() {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if ($requestMethod == "POST") {
            $storeName = $_POST['store_name'];

            try {
                $productModel = new ProductModel();

                $result = $productModel->findByStore($storeName);
                $resBody = json_encode($result);
            } catch (Error $e) {
                $e -> getMessage();
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

        }
        if (!$strErrorDesc) {
            $this->sendOutput(
                $resBody,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')

            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

}
?>