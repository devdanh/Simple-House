<?php
require_once 'mysql.php';
$pdo = get_pdo();

function register($email, $password, $role='user'){
    if(email_exisit($email))
        return false;
    
    global $pdo;

    $sql = "INSERT INTO USERS(ID, EMAIL, PASSWORD, ROLE) VALUES(NULL, :email, :password , :role)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);

    $stmt->execute();

    return login($email, $password);
}

function login($email, $password){
    global $pdo;

    $sql = "SELECT * FROM USERS WHERE EMAIL=:email AND PASSWORD=:password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); 
     
    // Lấy danh sách kết quả
    $result = $stmt->fetchAll();

    // Lặp kết quả
    foreach ($result as $row){
        return array(
            'id' => $row['id'],
            'email' => $row['email'],
            'password' => $row['password'],
            'role' => $row['role']
        );
    }

    return false;
}

function email_exisit($email){
    global $pdo;

    $sql = "SELECT * FROM USERS WHERE EMAIL=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); 
     
    // Lấy danh sách kết quả
    $result = $stmt->fetchAll();

    // Lặp kết quả
    foreach ($result as $row){
        return true;
    }

    return false;
}
?>