<!DOCTYPE html>

<html lang="en">
    <head>
        <title>DELTA - MY ACCOUNT</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Top 1 self-designed fashion in Singapore">
        <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/account.js"></script>
        <link rel="stylesheet" href="css/bootstrap.css"> 
        <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
        <link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="css/account.css">
        <link rel="stylesheet" href="css/accountsmall.css" media="screen and (max-width: 700px)">
        <link rel="stylesheet" href="css/accountmedium.css" media="screen and (min-width: 701px) and (max-width: 1200px)">
    </head>

    <body>
    <?php include 'header.inc.php'; ?>
        <main>
        <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }


            if (empty($_SESSION['email'])) {
                header("location:loginpage.php");
            }

            $email = $_SESSION['email']; // Email
            $acc_id = $_SESSION['acc_id']; // Account_ID
            echo $acc_id;
            include'dbcon.inc.php';


            function sanitize_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            // Get name of user based on email
            function getName($email) {
                $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME); //connect to database
                $name = $errorMsg = "";
                $success = true;
                if ($conn->connect_error) {
                    $errorMsg .= "Connection failed: " . $conn->connect_error;
                    $success = false;
                } 
                else {
                    // Modified sql paramaters to prevent SQL injections
                    $sql = $conn->prepare("SELECT * FROM account WHERE email = ?");
                    $sql->bind_param('s', $email);
                    $sql->execute();
                    $result = $sql->get_result();
                    $row = $result->fetch_assoc();
                    $result->free_result();  // Free result so that data will not be held up
                    $conn->close();         // Close connection
                    $name = $row['name'];

                    echo $name;
                }
            }

            // Check if there are any history or pre existing orders for user
            function getOrderByAccID($acc_id){
                $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME); //connect to database
                $errorMsg = "";
                $success = true;
                if ($conn->connect_error) {
                    $errorMsg .= "Connection failed at getOrderByAccID: " . $conn->connect_error;
                    $success = false;
                }

                else {
                    $sql = $conn->prepare("SELECT count(*) as FROM order_info where acc_id = ?");
                    $sql->bind_param('i', $acc_id);
                    $sql->execute();
                    $result = $sql->get_result();
                    $row = $result->fetch_assoc();
                    $result->free_result();
                    $conn->close();

                    $count = $row['count'];
                    if ($count > 0){
                        displayOrderByAccID($acc_id);
                    }
                    else {
                        echo "<h3 class='accountpageh3'> You have no past order history </h3>";
                    }
                }
            }

            // Display the overview modal of Order
            function displayOrderByAccID($acc_id){
                $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME); //connect to database
                $errorMsg = "";
                $success = true;
                if ($conn->connect_error) {
                    $errorMsg .= "Connection failed at displayOrderByAccID: " .$conn->connect_error;
                    $success = false;
                }

                else {
                    $sql = $conn->prepare("SELECT * FROM order_info where acc_id = ?");
                    $sql->bind_param('i', $acc_id);
                    $sql->execute();
                    $result = $sql->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $order_id = $row['order_id'];
                        $order_date = $row['order_date'];
                        $order_total_price = $row['order_total_price'];
                        $shipped = $row['shipped'];
                        $paid = $row['paid'];
                        $address = $row['address'];
                        echo "<article class='container-fluid ordercontainer'><section class = 'row text-center'>";
                        echo "<h3 class = 'accountpageh3'>";
                        if ($shipped == 'Y' ) {
                            echo "WE HAVE SENT IT!!";
                        }
                        else {
                            echo "WE ARE STILL PROCESSING YOUR ORDER..";
                        }
                        echo "</h3> <p class='orderdescription'>ORDER NO.: $order_id </p>";
                        echo "<p class='orderdescription'>TOTAL PRICE: $order_total_price </p>";
                        echo "<p class='orderdescription'>ORDER DATE: $order_date </p>";
                        echo "<p class='orderdescription orderline'> PAID: $paid </p>";
                        echo "<article>";
                            displayItemDetails($order_id);
                        echo "</article> </section> </article>";

                    }

                    $result->free_result();
                    $conn->close();
                }
            }

            function displayItemDetails($order_id) {
                $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME); //connect to database
                $errorMsg = "";
                $success = true;
                if ($conn->connect_error) {
                    $errorMsg .= "Connection failed at displayItemDetails: " .$conn->connect_error;
                    $success = false;
                }

                else {
                    $sql = $conn->prepare("SELECT order_item.quantity, item.item_id, item.img_source, item.product_price, item.size, item.product_name, item.product_col from item, order_item, order_info where item.item_id = order_item.item_id and order_item.order_id = ? AND order_info.order_id = ?");
                    $sql->bind_param('ii', $order_id, $order_id);
                    $sql->execute();
                    $result = $sql->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $item_id = $row['item_id'];
                        $img_source = $row['img_source'];
                        $product_col = $row['product_col'];
                        $size = $row['size'];
                        $product_name = $row['product_name'];
                        $qty = $row['quantity'];
                        $product_price = $row['product_price'];
                        echo "<figure class='containter-fluid ordericon'>";
                        echo "<a href='$product_col-php/$product_col$item_id.php'><img class='ordericon' src='$img_source' alt='$product_name'> </a>";
                        echo "<figcaption class='price text-center'>$product_name";
                        echo "<span class='visible-xs visible visible-sm visible-md visible-lg'>$product_price /pc </span>";
                        echo "<span class='visible-xs visible visible-sm visible-md visible-lg'>$size</span>";
                        echo "<span class='visible-xs visible visible-sm visible-md visible-lg'>$qty pc </span> </figcaption> </figure>";
                    }
                    $result->free_result();
                    $conn->close();
                }
            }


            // Display the images of order
            function displayOrderImages($order_id){
                echo $order_id;
                $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME); //connect to database
                $errorMsg = "";
                $success = true;
                if ($conn->connect_error) {
                    $errorMsg .= "Connection failed at displayOrderImagesByAccID: " .$conn->connect_error;
                    $success = false;
                }

                else {
                    $sql = "SELECT item.img_source, item.size, item.product_name from item, order_item, order_info where item.item_id = order_item.item_id and order_item.order_id = $order_id AND order_info.order_id = $order_id";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $img_source = $row['img_source'];
                        $size = $row['size'];
                        $product_name = $row['product_name'];
                        echo "<img class='ordericon' src='$img_source' alt='$product_name $size'>";
                    }
                }
            }

        ?>
            <article class='container-fluid accountcontainer'>
                <nav class="tab d-flex justify-content-center" title="Navigate through tabs">
                    <button class="tablinks" id='accountinfo'><span class="glyphicon glyphicon-user"></span>  Account Info</button>
                    <button class="tablinks" id='orders'><span class="glyphicon glyphicon-shopping-cart"></span>  My Orders</button>
    <!--                <button class="tablinks" id='payment'><span class="glyphicon glyphicon-credit-card"></span>  Payment Methods</button>-->
                </nav>
                <figure id="default" class="defaulttab ">
                    <img class="accountbackground" id='accountbackground' src="background.jpeg" alt="" >
                    <figcaption> 
                        <h1 class='accountbackgroundfont'>Hello <?php getName($email) ?>, 
                            Welcome to Your Account</h1>
                    </figcaption>       
                </figure>
                <section id="accountinfo1" class="tabitems text-center">
                    <h2 class="accountpageh1"><span class="glyphicon glyphicon-user"></span>  MY ACCOUNT INFO</h2>
                    <p class="accountpagecaption">You may change your password here</p>
                    <form name='accountForm' class="accountinfo-form" method="post" action="<?php echo htmlspecialchars('updatepw.php') ?>">
                            <label for='email' class="inputtitle">EMAIL : </label>
                            <input readonly='readonly' type="email" class="accountinfo-form-style" id="email" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" value="<?php echo $email ?>">
                            <label for='firstname' class="inputtitle">NAME : </label>
                            <input readonly='readonly' type="text" class="accountinfo-form-style" id="firstname" pattern="(?=^[A-Za-z]+\s?[A-Za-z]+$).{3,30}" value="<?php getName($email) ?>" >
                            <label for='pwd' class="inputtitle">PASSWORD : </label>
                            <input type="password" class="accountinfo-form-style" name="pwd" id="pwd" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,60}$" required />
                            <label for='newpwd' class='inputtitle'> NEW PASSWORD : </label>
                            <input type='password' class='accountinfo-form-style' name="newpwd" id='newpwd' pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,60}$" required /> 
                            <label for='cfmnewpwd' class='inputtitle'> CONFIRM NEW PASSWORD : </label>
                            <input type='password' class='accountinfo-form-style' name="cfmnewpwd" id='cfmnewpwd' pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,60}$" required />
                            <button type="submit" name="updatepwd" id="updatepwd" class="btn1 btn-submit">Update Password</button>
                    </form>
                </section>
                <section id="orders1" class="tabitems ">
                    <h2 class="accountpageh1 text-center"><span class="glyphicon glyphicon-shopping-cart"></span>  MY ORDERS</h2>
                    <p class="accountpagecaption text-center">An overall view of your past purchases</p>

                    <article class="container-fluid ordercontainer">
                        <?php displayOrderByAccID($acc_id); ?>
                    </article>
                </section>
            </article>
        </main>
        <?php include 'footer.inc.php';?>
    </body>

</html>
