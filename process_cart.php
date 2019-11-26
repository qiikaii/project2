<?php
include 'dbcon.inc.php';
include 'header.inc.php';

//define variables
$db_error_msg = $submit_error = $success = $product_id = $quantity = "";

if ($conn->connect_error) {
    $db_error_msg = "Connection failed: " . $conn->connect_error;
}
//start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//obtaining add to cart values
$product_id = sanitize_input($_POST['product_id']);
$quantity = sanitize_input($_POST['quantity']);
$size = sanitize_input($_POST['size']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['add_cart'])) {
        header("Location: error.php");
    } else {
        //validating input
        if ($size != 'S' || $size != 'M' || $size != 'L') {
            $success = false;
            header("Location: error.php");
        }

        //obtaining the right product id
        $product_id = get_product_id($product_id, $size);

        if (!isset($_SESSION['acc_id'])) {
            header("Location: cartpage.php");
        } else {
            //validating input
            if ($quantity > 10 || $quantity < 1) {
                $success = false;
                header("Location: error.php");
            } else {
                // add_to_db(ACC_ID, $product_id, $quantity);
                add_to_db($_SESSION['acc_id'], $product_id, $quantity);

                // header("Location:" . $_SERVER['HTTP_REFERER']);
                header("Location: cartpage.php");
                die();
            }
        }
    }
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

    $result->free_result();
    unset($result, $row);

    // if it does not exist in the cart
    $sql = "INSERT INTO cart (acc_id, item_id, quantity) VALUES ($acc_id, $item_id, $quantity);";
    $conn->query($sql);

    $conn->close();
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
