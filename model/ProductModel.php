<?php
require_once PROJECT_ROOT_PATH . "/model/Database.php";
class ProductModel extends Database
{
    public function getProducts($limit)
    {
        return $this->select("SELECT * FROM product ORDER BY product_id ASC LIMIT ?", ["i", $limit]);
    }

    public function createProduct($storeId, $productName, $description, $price, $quantity) {
        $this->doQuery("INSERT INTO customer (customer_name, email, address, phone_number, password) VALUES (?,?,?,?,?)", ["sssss",$storeId, $productName, $description, $price, $quantity]);
    }
    
    public function updateProductInfo($productId ,$storeId, $productName, $description, $price, $quantity) {
        $this->doQuery("UPDATE customer 
        SET store_id = ?, product_name = ? , description = ? , price = ? , quantity = ?
        WHERE product_id = ?
        ", ["sssss",$storeId, $productName, $description, $price, $quantity, $productId]); 
    }

    public function deleteProduct($productId) {
        $this->doQuery("DELETE FROM product WHERE product_id = ?", ["s", $productId]);
    }

    public function findByName($name) {
        $this->doQuery("SELECT * FROM product WHERE product_name = ? ", ["s", $name]);
    }
}
?>