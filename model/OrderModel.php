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
    
    public function updateOrderStatusInfo($status, $orderId) {
        $this->doQuery("UPDATE orderlist 
        SET status = ?
        WHERE order_id = ?
        ", ["ss",$status, $orderId]); 
    }

    public function deleteOrder($orderId) {
        $this->doQuery("DELETE FROM orderlist WHERE order_id = ?", ["s", $orderId]);
    }

    public function findById($orderId) {
        $this->select("SELECT * FROM ordelist WHERE order_id = ? ", ["s",$orderId]);
    }
}
?>