<?php
require_once PROJECT_ROOT_PATH . "/model/Database.php";
class OrderModel extends Database
{
    public function getOrders($limit)
    {
        return $this->select("SELECT * FROM orderlist ORDER BY order_id ASC LIMIT ?", ["i", $limit]);
    }

    public function createOrder($customerId, $totalAmount, $status) {
        $this->doQuery("INSERT INTO orderlist (customer_id, total_amount, status) VALUES (?,?,?)", ["sss",$customerId, $totalAmount, $status]);
    }
    
    public function updateOrderInfo($orderId, $customerId, $totalAmount, $status) {
        $this->doQuery("UPDATE orderlist 
        SET customer_id = ? , total_amount = ? , status = ?
        WHERE order_id = ?
        ", ["ssss",$customerId, $totalAmount, $status, $orderId]); 
    }

    public function deleteOrder($customerId, $totalAmount, $status) {
        $this->doQuery("INSERT INTO orderlist (customer_id, total_amount, status) VALUES (?,?,?)", ["sssss",$customerId, $totalAmount, $status]);
    }

    public function findById($customerId, $totalAmount, $status) {
        $this->doQuery("INSERT INTO customer (customer_id, total_amount, status) VALUES (?,?,?)", ["sssss",$customerId, $totalAmount, $status]);
    }
}
?>