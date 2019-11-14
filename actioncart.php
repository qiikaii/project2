<!DOCTYPE html>
<html lang="en">
    <title>DELTA - Error Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Top 1 self-designed fashion in Singapore">
    <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css"> 
    <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/errorstyling.css">
</html>

<?php
session_start();
include 'header.php';
$acc_id = $_SESSION['acc_id'];
$errorMsg = false;

if (isset($_POST["updatecart"])) {
    if (empty($_POST["cartitemid"])) {
        $errorMsg .= "Invalid item.<br>";
        $success = false;
    } else {
        $item_id = sanitize_input($_POST["cartitemid"]);
        $existitem = false;
        if (!preg_match('/^[0-9]{0,2}$/', $item_id)) {
            $errorMsg .= "Invalid item.<br>";
            $success = false;
        }
        
        else {
            include 'dbcon.php';
            $checkitem = "SELECT item_id FROM item WHERE item_id = '$item_id'";
            $result = $conn->query($checkitem);
            if ($result->num_rows == 1) {
            }
            else {
                $errorMsg .= "Invalid item.<br>";
                $success = false;
                $conn->close();
            }
            $result->free_result();
        }
    }

    if (empty($_POST["cartquantity"])) {
        $errorMsg .= "Invalid quantity.<br>";
        $success = false;
    } else {
        $cartquantity = sanitize_input($_POST["cartquantity"]);
        if (!preg_match('/^[0-9]{0,2}$/', $cartquantity)) {
            $errorMsg .= "Invalid quantity.<br>";
            $success = false;
        }
    }

    // Check stock of item purchased
    
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
} else if (isset($_POST["deletecart"])) {

    if (empty($_POST["cartitemid"])) {
        $errorMsg .= "Invalid item.<br>";
        $success = false;
    } else {
        $item_id = sanitize_input($_POST["cartitemid"]);
        if (!preg_match('/^[0-9]{0,2}$/', $item_id)) {
            $errorMsg .= "Invalid item.<br>";
            $success = false;
        }
        else {
            include 'dbcon.php';
            $checkitem = "SELECT item_id FROM item WHERE item_id = '$item_id'";
            $result = $conn->query($checkitem);
            $conn->close();
            if ($results->num_rows != 1) {
                $errorMsg .= "Invalid item.<br>";
                $success = false;
            }
            $result->free_result();
        }
    }
    

    if (empty($_POST["cartquantity"])) {
        $errorMsg .= "Invalid quantity.<br>";
        $success = false;
    } else {
        $cartquantity = sanitize_input($_POST["cartquantity"]);
        if (!preg_match('/^[0-9]{0,2}$/', $cartquantity)) {
            $errorMsg .= "Invalid quantity.<br>";
            $success = false;
        }
        
    }

    include 'dbcon.php';
    $sql = "DELETE FROM cart WHERE acc_id = '$acc_id' AND item_id = '$item_id'";
    $result = $conn->query($sql);
    $conn->close();
    header("location:cartpage.php");
    
} else {
    $errorMsg = "Please submit the form from the cart page.<br>";
    $success = false;
}

//Helper function that checks input for malicious or unwanted content.
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (!$success) {
    echo "<section class=\"middle\">
    <h4>The following input errors were detected:</h4>
    <p> $errorMsg </p>
    </section>";
}
include 'footer.php';
?>
