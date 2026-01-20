<?php

class  Product{
    protected $conn;
    public function __construct(){
        global $conn;
        $this->conn = $conn;
    }

    public function listAllProducts() // listanje na site produkti od baza
    {
        $sql = "SELECT * FROM product";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function create($name,$price,$size,$image){
        $query = "INSERT INTO product (name,price,size,image) VALUES(?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss",$name,$price,$size,$image);
        $stmt->execute();
    }
    public function read($product_id){  // prevzemanje na eden konkreten produkt
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function edit($product_id,$name,$price,$size,$image){
        $query = "UPDATE product SET name = ?, price = ?, size = ?, image = ? WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", $name, $price, $size, $image, $product_id);
        $stmt->execute();
    }
    public function delete($product_id){
        $query = "DELETE FROM product WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
    }


}