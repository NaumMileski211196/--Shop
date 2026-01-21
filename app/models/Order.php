<?php
require_once __DIR__ . "/Cart.php";
require_once __DIR__ . "/../config/config.php";
class Order extends Cart {
    protected $conn;
    public function __construct(){
        global $conn;
        $this->conn = $conn;
    }
    public function createOrder($deliveryAddress){
        $stmt = $this->conn->prepare("INSERT INTO orders (user_id, deliveryAddress) VALUES (?, ?)");
        $stmt->bind_param("is", $_SESSION['user_id'], $deliveryAddress);

        if(!$stmt->execute()){
            return false;
        }

        $order_id = $this->conn->insert_id;
        $cart_items = $this->list_cart_items();

        $stmt = $this->conn->prepare("INSERT INTO order_items (order_id,product_id,quantity) VALUES (?, ?,?)");

        foreach($cart_items as $item){
            $stmt->bind_param("iis", $order_id, $item["product_id"], $item["quantity"]);
            $stmt->execute();
        }
        $this->destroy_cart();
        return true;
    }
    public function get_orders(){
        $user_id = $_SESSION['user_id'];
        $sql = "
        SELECT
            orders.order_id,
            orders.deliveryAddress,
            orders.created_at,
            order_items.quantity,
            product.name,
            product.price,
            product.size,
            product.image
        FROM orders
        INNER JOIN order_items ON orders.order_id = order_items.order_id
        INNER JOIN product ON order_items.product_id = product.product_id
        WHERE orders.user_id = ?
        ORDER BY orders.created_at DESC
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function get_admin_orders(){
        $sql = "
        SELECT 
            o.order_id,
            o.deliveryAddress,
            o.created_at,
            u.name AS user_name,
            u.email,
            oi.quantity,
            p.image,
            SUM(oi.quantity * p.price) AS total_price
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN product p ON oi.product_id = p.product_id
        GROUP BY o.order_id
        ORDER BY o.created_at DESC
    ";

        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
