<?php
require_once PROJECT_ROOT_PATH . "/model/Database.php";
class CustomerModel extends Database
{
    public function getCustomers($limit)
    {
        return $this->select("SELECT * FROM customer ORDER BY customer_id ASC LIMIT ?", ["i", $limit]);
    }

    public function createCustomer($name, $email, $address, $phoneNumber,$password) {
        $this->doQuery("INSERT INTO customer (customer_name, email, address, phone_number, password) VALUES (?,?,?,?,?)", ["sssss",$name, $email, $address, $phoneNumber, $password]);
    }
    
    public function updateCustomerInfo($name, $email, $address, $phoneNumber,$password) {
        $this->doQuery("UPDATE customer 
        SET customer_name = ? , email = ? , address = ?, phone_number = ?, password = ?
        WHERE email = ?
        ", ["sssss",$name, $email, $address, $phoneNumber, $password, $email]); 
    }

    public function deleteCustomer($email) {
        $this->doQuery("DELETE FROM customer WHERE email = ? ", ["s",$email]);
    }

    public function findByEmail( $email ) {
        $this->doQuery("SELECT * FROM customer WHERE email = ?", ["s", $email]);
    }
}
?>