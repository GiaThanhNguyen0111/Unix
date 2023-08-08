<?php
require_once PROJECT_ROOT_PATH . "/model/Database.php";
class StoreModel extends Database
{
    public function getStores($limit)
    {
        return $this->select("SELECT * FROM store ORDER BY store_id ASC LIMIT ?", ["i", $limit]);
    }

    public function createStore($name, $phoneNumber, $address) {
        $this->doQuery("INSERT INTO customer (customer_name, email, address, phone_number, password) VALUES (?,?,?)", ["sssss",$name, $phoneNumber, $address]);
    }
    
    public function updateStoreInfo($storeId ,$name, $phoneNumber, $address) {
        $this->doQuery("UPDATE customer 
        SET customer_name = ? , email = ? , address = ?, phone_number = ?, password = ?
        WHERE product_id = ?
        ", ["sss",$name, $phoneNumber, $address, $storeId]); 
    }

    public function deleteStore($name, $phoneNumber, $address) {
        $this->doQuery("INSERT INTO customer (name, phone_number, address) VALUES (?,?,?)", ["sss",$name, $phoneNumber, $address]);
    }

    public function findById($name, $phoneNumber, $address) {
        $this->doQuery("INSERT INTO customer (customer_name, email, address, phone_number, password) VALUES (?,?,?)", ["sss",$name, $phoneNumber, $address]);
    }
}
?>