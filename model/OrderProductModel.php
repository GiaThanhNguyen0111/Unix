<?php
require_once PROJECT_ROOT_PATH . "/model/Database.php";
class OrderProductModel extends Database
{   
    // This function return list of product ID;
    public function findByOrderId ($orderId) {
        return $this->select("SELECT product_id 
                            FROM order_list 
                            WHERE order_id = ?", ["s", $orderId]);
    }

    public function insertList($arr, $orderId) {
        foreach($arr as $key => $value) {
            $this->doQuery("INSERT INTO order_list VALUES (?,?,?)", ["sss", $orderId, $key, $value]);
        }
    }

}
?>