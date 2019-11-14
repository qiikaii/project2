<?php


session_start();
$item_id = $_POST['cartitemid'];
$cartquantity = $_POST["cartquantity"];
$acc_id = $_SESSION['acc_id'];

//if (!isset("cart"))

if (isset($_POST["updatecart"])) {
    // Check stock of item purchased
    include 'dbcon.php';
    $sql = "SELECT quantity FROM item WHERE item_id = '$item_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $result->free_result();
    $stock = $row['quantity'];

    // If item requested to place in cart more than stock, you can only request to what the stock avail.
    if ($cartquantity > $stock) {
        $cartquantity = $stock;
    }

    // If cart quantity less than or equal to 0, delete from cart
    if ($cartquantity <= 0) {
        $sql = "DELETE FROM cart WHERE acc_id = '$acc_id' AND item_id = '$item_id'";
        $result = $conn->query($sql);
        $conn->close();
        header("location:cartpage.php");
    }

    // Cannot update more than 99 values
    if ($cartquantity >= 99) {
        $cartquantity = 99;
        $sql = "UPDATE cart SET quantity = '$cartquantity' WHERE acc_id = '$acc_id' AND item_id = '$item_id'";
        $result = $conn->query($sql);
        $conn->close();
        header("location:cartpage.php");
    }

    // Update item quantity in cart
    else {
        $sql = "UPDATE cart SET quantity = '$cartquantity' WHERE acc_id = '$acc_id' AND item_id = '$item_id'";
        $result = $conn->query($sql);
        $conn->close();
        header("location:cartpage.php");
    }
}

if (isset($_POST["deletecart"])) {
    include 'dbcon.php';
    $sql = "DELETE FROM cart WHERE acc_id = '$acc_id' AND item_id = '$item_id'";
    $result = $conn->query($sql);
    $conn->close();
    header("location:cartpage.php");
}
?>