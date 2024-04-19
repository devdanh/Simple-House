<?php

require_once './core/mysql.php';

$pdo = get_pdo();

//Insert order
function insert_order($code, $status, $user_id){
    $sql = "INSERT INTO ORDERS(ID, CODE, STATUS, USER_ID) VALUES(NULL, :code, :status, :user_id)";
    global $pdo;
    $stmt = $pdo->prepare($sql);
   
    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();
}

//update order
function update_order($code, $status, $user_id, $id){
    $sql = "UPDATE ORDERS SET CODE=:code, STATUS=:status WHERE ID=:id";
    global $pdo;
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':id', $id);

   
    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);

    $stmt->execute();
}

//delete order
function delete_order($id){
    $sql = "DELETE FROM ORDERS WHERE ID=:id";
    global $pdo;
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':id', $id);

    $stmt->execute();
}

//Select data
function get_order_list(){
    $sql = "SELECT * FROM ORDERS";
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
            'code' => $row['code'],
            'status' => $row['status'],
            'user_id' => $row['user_id'],
        ));
    }

    return $order_list;
}

function find_order($id){
    $sql = "SELECT * FROM ORDERS WHERE ID=:id";
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
            'code' => $row['code'],
            'status' => $row['status'],
            'user_id' => $row['user_id'],
        );
    }

    return null;
}

function find_order_by_code($code){
    $sql = "SELECT * FROM ORDERS WHERE CODE=:code";
    global $pdo;
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':code', $code);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); 
     
    // Lấy danh sách kết quả
    $result = $stmt->fetchAll();
     
    // Lặp kết quả
    foreach ($result as $row){
        return array(
            'id' => $row['id'],
            'code' => $row['code'],
            'status' => $row['status'],
            'user_id' => $row['user_id'],
        );
    }

    return null;
}
?>