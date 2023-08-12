<?php
session_start();
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

        };
        if (!$strErrorDesc) {
            $this->sendOutput(
                json_encode(array("data"=> "Log In Successful")),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
            array('Content-Type: application/json', $strErrorHeader)
        );
        }
    }

    public function updateInfoAction () {
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

                

                try {
                    $customerModel = new CustomerModel();

                    $customerModel->updateCustomerInfo($name, $email, $address, $phoneNumber, $password);
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
                json_encode(array("isUpdated"=> true)),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc,
                                                'isUpdated' => false)), 
            array('Content-Type: application/json', $strErrorHeader)
        );
        }    
    }

    public function deleteCustomerAction () {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if ($requestMethod == "POST") {
            if (count($_POST)) {
                $email = $_POST['email'];
                
            

                try {
                    $customerModel = new CustomerModel();

                    $customerModel->deleteCustomer($email);
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
                json_encode(array("isDeleted"=> true)),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc,
                                                'isDeleted' => false)), 
            array('Content-Type: application/json', $strErrorHeader)
        );
        }
    }
    public function findByEmailAction() {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();

        if ($requestMethod == "POST") {
            if (count($_POST)) {
                $email = $_POST['email'];
               
                try {
                    $customerModel = new CustomerModel();

                    $result = $customerModel->findByEmail($email);
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
    public function signInAction() {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();
        $isLoggedIn = true;

        if ($requestMethod == "POST") {
            if (count($_POST)) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                try {
                    $customerModel = new CustomerModel();

                    $result = $customerModel->findByEmail($email)[0];

                    $customerId = $result['customer_id'];

                    if ($this->checkPassword($email, $password) == 1 && $this->checkEmail($email, $password) == 1) {
                        $isLoggedIn = true;
                    } else {
                        $isLoggedIn = false;
                    }
                } catch (Error $e) {
                    $e -> getMessage();
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
                
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

        }
        if (!$strErrorDesc) {
            $this->sendOutput(
                json_encode(array("isLoggedIn"=> $isLoggedIn,
                                    "customerId" => $customerId)),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
            array('Content-Type: application/json', $strErrorHeader)
        );
    }
    }

    public function signOutAction() {
        $strErrorDesc = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams =$this->getQueryStringParams();
        $isLoggedIn = true;

        if ($requestMethod == "GET") {
                $isLoggedIn = false;
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

        }
        if (!$strErrorDesc) {
            $this->sendOutput(
                json_encode(array("isLoggedIn"=> $isLoggedIn)),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc,
                                                "isLoggedIn" => $isLoggedIn)), 
            array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    
    private function checkEmail($emailInput) {
        try {
            $customerModel = new CustomerModel();

            $user = $customerModel->findByEmail($emailInput)[0];

            if (!isset($user)) {
                return 0;
            }
            return 1;
        } catch (Error $e) {
            $e -> getMessage();
        }
    }

    private function checkPassword($emailInput ,$passwordInput) {
        try {
            $emailIsExisted = $this->checkEmail($emailInput);

            $customerModel = new CustomerModel();

            $user = $customerModel->findByEmail($emailInput);

            if ($passwordInput == $user[0]["password"] && $emailIsExisted == 1) {
                return 1;
            } 
            return 0;
        } catch (Error $e) {
            $e->getMessage();
        }

    }

}
?>