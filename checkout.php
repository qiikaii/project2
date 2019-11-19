<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DELTA - CHECK OUT</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Top 1 self-designed fashion in Singapore">
        <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.css"> 
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/checkout.css">
        <link rel="stylesheet" href="css/errorstyling.css">
        <script src="js/checkout.js"></script>
    </head>

    <main>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
        session_start();
        }
        include 'header.inc.php';
        $success = true;
        if (!isset($_SESSION['acc_id'])) {
            $errorMsg = "Please login to checkout.<br>";
            $success = false;
        }
        
        include 'dbcon.inc.php';
        $acc_id = $_SESSION['acc_id'];
        $checkcartsql = "SELECT COUNT(*) as count FROM cart WHERE acc_id = '$acc_id'";
        $result = $conn->query($checkcartsql);    
        $row = $result->fetch_assoc();
        $result->free_result();
        $conn->close();
        if ($row['count'] <= 0) {
            $errorMsg = "There is no items in the cart.<br>";
            $success = false;
        }
        
        else {
            ?>
            <section class="checkoutbody">
                <h1 class="maintitle">CHECK OUT</h1>
                <form name="checkoutform" action="<?php echo htmlspecialchars("processcheckout.php"); ?>" method="post">
                    <label for="address" class="separator">Shipping Address:
                        <input class="separator" name="address" id="address" type="text" placeholder="Where do you want us to ship to?" 
                               size="60" maxlength="200" autocomplete="off" pattern="/^[a-zA-Z0-9]+( [a-zA-Z0-9]+)*$/" required></label>
                    <label for="postal" class="separator">Postal Code: 
                        <input class="separator" name="postal" id="postal" type="text" placeholder="Deliver to Singapore only." 
                               size="60" maxlength="6" autocomplete="off" pattern="^[0-9]{6}$" required></label>
                    <button class="checkoutbutton" name="checkoutbutton" id="checkoutbutton">CHECK OUT</button>
                    <p class="separatorlink">—— Please pay within 7 working days to process orders ——</p>
                </form>
            </section>
        <?php
        }
        
        if (!$success) {
            echo "<section class=\"middle\">
            <h4>The following errors were detected:</h4>
            <p> $errorMsg </p>
            </section>";
        }
        include 'footer.inc.php';
        ?>
    </main>
</html>