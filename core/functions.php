<?php
require_once 'product_db.php';

function add_to_cart( $product_id, $quantity = 1 )
{
    $product = get_product($product_id);
    $product_exist = true;

    if ( isset( $_SESSION['cart'] ) ) {
        $cart = $_SESSION['cart'];
        $product_exist = check_product_exist($product_id);
    } else {
        $cart = array();
        $product_exist = false;
    }

    if ( !$product_exist ) {
        $order_detail = array(
            "product_id" => $product["id"],
            "img" => $product["img"],
            "name" => $product["name"],
            "price" => $product["price"],
            "quantity" => $quantity
        );

        array_push($cart, $order_detail);

        $_SESSION['cart'] = $cart;
    }else{
        update_to_cart( $product["id"], $quantity );
    }
}

function delete_from_cart( $product_id )
{
    $cart = $_SESSION['cart'];
    $rs = array();

    foreach (  $cart as $order_detail ) {
        if ($order_detail['product_id'] != $product_id) {
            array_push($rs, $order_detail);
        }
    }

    $_SESSION['cart'] = $rs;
}

function update_to_cart($product_id, $increment)
{
    $cart = $_SESSION['cart'];
    $rs = array();

    foreach ( $cart as $order_detail ) {
        if ($order_detail['product_id'] == $product_id) {
            $order_detail['quantity'] += $increment;
            if( $order_detail['quantity'] < 1 )
                $order_detail['quantity'] = 1;
        }
        array_push($rs, $order_detail);
    }

    $_SESSION['cart'] = $rs;
}

function get_cart()
{
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
}

function check_product_exist($product_id)
{
    $cart = $_SESSION['cart'];
    $rs = array();
    $is_exist = false;

    foreach ( $cart as $order_detail ) {
        if ( $order_detail['product_id'] == $product_id ) {
            $order_detail['quantity'] += 1;
            $is_exist = true;
        }
        array_push($rs, $order_detail);
    }

    $_SESSION['cart'] = $rs;
    return $is_exist;
}

function total_cart_item( $price, $quantity ){
    return number_format( $price * $quantity, 0, '', ',');
}

function total_cart(){
    $cart = $_SESSION['cart'];
    $total = 0;
    foreach ($cart as $order_detail) {
        $total += $order_detail['price'] * $order_detail['quantity'];
    }
    return number_format($total, 0, '', ',');
}

/**
 * Ham dem so luong product trong gio hang
 */
function number_cart_product(){
    $cart = $_SESSION['cart'];
    $number = 0;
    foreach ($cart as $order_detail) {
        $number += $order_detail['quantity'];
    }
    return $number;
}

function string_random($len = 10){
    $keys = array_merge(range(0,9), range('a', 'z'));

    $key = "";
    for($i=0; $i < $len; $i++) {
        $key .= $keys[mt_rand(0, count($keys) - 1)];
    }
    return $key;
}