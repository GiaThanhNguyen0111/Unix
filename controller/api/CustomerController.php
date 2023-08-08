<?php
class CustomerController extends BaseController {
    public function listAction() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if (strtoupper($requestMethod) == "GET") {
            try {
                $customerModel = new CustomerModel();

                $intLimit = 10;

                if (isset ($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }

                $arrCustomer = $customerModel -> getCustomers($intLimit);
                $responseData = json_encode($arrCustomer);
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

    public function signUpAction() {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if ($requestMethod == "POST") {
            if (count($_POST)) {
                $name = $_POST['username'];
                $email = $_POST['email'];
                $address = $_POST['address'];
                $phoneNumber = $_POST['phoneNumber'];
                $password = $_POST['password'];

                echo $name;
                echo $email;

                try {
                    $customerModel = new CustomerModel();

                    $customerModel->createCustomer($name, $email, $address, $phoneNumber, $password);
                } catch (Error $e) {
                    $e -> getMessage();
                }
                
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

        }
    }

}
?>