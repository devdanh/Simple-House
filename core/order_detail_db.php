<?php

require_once './core/mysql.php';

$pdo = get_pdo();

//Insert order
function insert_order_detail($product_id, $order_id, $quantity){
    $sql = "INSERT INTO ORDER_DETAILS(ID, PRODUCT_ID, ORDER_ID, QUANTITY) VALUES(NULL, :product_id, :order_id, :quantity)";
    global $pdo;
    $stmt = $pdo->prepare($sql);
   
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->bindParam(':quantity', $quantity);

    $stmt->execute();
}

//update order
function update_order_detail($product_id, $order_id, $quantity){
    $sql = "UPDATE ORDER_DETAILS SET PRODUCT_ID=:product_id, ORDER_ID=:order_id, QUANTITY=:quantity WHERE ID=:id";
    global $pdo;
    $stmt = $pdo->prepare($sql);
   
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->bindParam(':quantity', $quantity);

    $stmt->execute();
}

//delete order
function delete_order_detail($id){
    $sql = "DELETE FROM ORDER_DETAILS WHERE ID=:id";
    global $pdo;
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':id', $id);

    $stmt->execute();
}

//Select data
function get_order_detail_list(){
    $sql = "SELECT * FROM ORDER_DETAILS";
    global $pdo;
    $stmt = $pdo->prepare($sql);
    

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); 
     
    // Lấy danh sách kết quả
    $result = $stmt->fetchAll();
     
    // Lặp kết quả
    $order_list = [];

    foreach ($result as $row){
        array_push($order_list, array(
            'id' => $row['id'],
            'product_id' => $row['product_id'],
            'order_id' => $row['order_id'],
            'quantity' => $row['quantity'],
        ));
    }

    return $order_list;
}

function find_order_detail($id){
    $sql = "SELECT * FROM ORDER_DETAILS WHERE ID=:id";
    global $pdo;
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); 
     
    // Lấy danh sách kết quả
    $result = $stmt->fetchAll();
     
    // Lặp kết quả
    foreach ($result as $row){
        return array(
            'id' => $row['id'],
            'product_id' => $row['product_id'],
            'order_id' => $row['order_id'],
            'quantity' => $row['quantity'],
        );
    }

    return null;
}
?>