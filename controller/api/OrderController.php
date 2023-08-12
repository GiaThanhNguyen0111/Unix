<?php
class OrderController extends BaseController {
    public function listAction() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if (strtoupper($requestMethod) == "GET") {
            try {
                $orderModel = new OrderModel();

                $intLimit = 10;

                if (isset ($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }

                $arrOrder = $orderModel -> getOrders($intLimit);
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

    public function createOrderAction() {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if ($requestMethod == "POST") {
            if (count($_POST)) {
                // customer Id
                $customerId = $_POST['customer_id'];
                // order Id

                // list of Product Id and quantity
                $listOfProductId = $_POST['list_of_product'];

                //status
                $status  = $this->isPaid() ? 1 : 0;
                // totalAmount
                $totalAmount = $_POST['total_amount'];

                try {
                    $orderModel = new OrderModel();

                    $orderId = $orderModel->createOrder($customerId, $totalAmount, $status);

                    $orderProductModel = new OrderProductModel();
                    
                    $orderProductModel->insertList($listOfProductId, $orderId);
                    
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
                                                'isCreated' => false)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function updateOrderStatusAction () {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if ($requestMethod == "POST") {
            if (count($_POST)) {
                $status = $_POST['status'];

                try {
                    $orderModel = new OrderModel();
                    if (isset ($arrQueryStringParams['orderId']) && $arrQueryStringParams['orderId']) {
                        $orderId = $arrQueryStringParams['orderId'];
                    }
                    $orderModel->updateOrderStatusInfo($status, $orderId);
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
                                                'isUpdated' => false)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function deleteOrderAction () {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if ($requestMethod == "POST") {
            if (count($_POST)) {
                $orderId = $_POST['order_id'];
                
                echo $orderId;

                try {
                    $orderModel = new OrderModel();

                    $orderModel->deleteOrder($orderId);
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

    public function findByIdAction() {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if ($requestMethod == "POST") {
            if (count($_POST)) {
                $orderId= $_POST['order_id'];

                try {
                    $orderModel = new OrderModel();

                    $result = $orderModel->findById($orderId);
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

    private function calcTotalAmount () {
        return 100000;
    }

    private function isPaid() {
        return false;
    }

}
?>