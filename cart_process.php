<?php
include 'session.php';
include 'dbcon.php';

if ($conn->connect_error) {
    $db_error_msg = "Connection failed: " . $conn->connect_error;
}

// temp TBD
$_SESSION['acc_id'] = "67191009";
// define("ACC_ID", "23572289");

//define variables
$product_id = $quantity = $account_id = "";

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$size = $_POST['size'];

// add to DB
$product_id = get_product_id($product_id, $size);

if (!isset($_SESSION['acc_id'])) {
    header("Location: cartpage.php");
} else {
    // add_to_db(ACC_ID, $product_id, $quantity);
    add_to_db($_SESSION['acc_id'], $product_id, $quantity);

    // header("Location:" . $_SERVER['HTTP_REFERER']);
    header("Location: cartpage.php");
    die();
}


/** 
 * check and update DB if order exist
 * 
 * @param int $acc_id
 * @param int $item_id
 * @param int $quantity
 * 
 * @return null
 */
function add_to_db($acc_id, $item_id, $quantity)
{
    global $conn;
    // check if it exists in the cart
    $sql = "SELECT * FROM cart WHERE item_id = $item_id AND acc_id = $acc_id;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // update cart if exist
        $sql = "UPDATE cart SET quantity = quantity + $quantity WHERE item_id = $item_id AND acc_id = $acc_id;";
        $conn->query($sql);
        return;
    } // if

    // if it does not exist in the cart
    $sql = "INSERT INTO cart (acc_id, item_id, quantity) VALUES ($acc_id, $item_id, $quantity);";
    $conn->query($sql);
}

function get_product_id($item_id, $size)
{
    switch ($size) {
        case 'S':
            return $item_id;
        case 'M':
            return $item_id + 1;
        case 'L':
            return $item_id + 2;
    } // switch
} // get_product_id()
