<!DOCTYPE html>

<html>
    <head>
        <title>DELTA - MY ACCOUNT</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Top 1 self-designed fashion in Singapore">
        <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script src="js/slideshow.js"></script>
        <script src="js/main.js"></script>
        <script src="js/account.js"></script>
        <link rel="stylesheet" href="css/bootstrap.css"> 
        <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/font-awesome.css">
        <link rel="stylesheet" href="css/account.css">
        <link rel="stylesheet" href="css/accountsmall.css" media="screen and (max-width: 700px)">
        <link rel="stylesheet" href="css/accountmedium.css" media="screen and (min-width: 701px) and (max-width: 1200px)">
    </head>

    <body>
    <?php
        if (session_status() == PHP_SESSION_NONE){
            session_start();
        }        
        include 'header.php';

        $acc_id = $_SESSION['acc_id'];
        echo $acc_id;
        
        // Get name of user based on email
        function getName($session) {
            include 'dbcon.php';
            //Create connection
            //define variables and set to empty values
            $name = $errorMsg = "";
            $success = true;
            if ($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            } 
            else {
                $sql = "SELECT * FROM account WHERE email = '$session'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $result->free_result();
                $conn->close();

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
                $sql = "SELECT count(*) as FROM order_info where acc_id = $acc_id";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $result->free_result();
                $conn->close();
                $count = $row['count'];
                if ($count > 0){
                    displayOrderByAccID($acc_id);
                }
                else {
                    // TO BE IMPLEMENTED
                    // ECHO NO ORDER
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
                $sql = "SELECT * FROM order_info where acc_id = $acc_id";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $order_id = $row['order_id'];
                    $order_date = $row['order_date'];
                    $order_total_price = $row['order_total_price'];
                    $shipped = $row['shipped'];
                    echo "<section class = 'row text-center'>"
                        . "<h3 class = 'accountpageh3'>";
                    if ($shipped == 'Y') {
                        echo "WE'VE SENT IT!! </h3>";
                    }
                    else {
                        echo "WE'RE STILL PROCESSING YOUR ORDER.. </h3>";
                    }
                    echo "<p class='orderdescription'>ORDER NO.: $order_id </p>"
                        ."<p class='orderdescription'>TOTAL PRICE: $order_total_price </p>"
                        ."<p class='orderdescription orderline'>ORDER DATE: $order_date </p>"
                        ."<article>";
                        displayOrderImages($order_id);
                    echo "</article>"
                        ."<button type='button' class='btn1 btn-submit' data-toggle='modal' data-target='#orderModalPopup'> VIEW ORDER </button>"
                        ."<section class='orderModal fade text-center' id='orderModalPopup' tabindex='-1' role='dialog'>"
                            ."<article class='modal-dialog' role='document'>"
                                ."<article ckass='orderDetails-content'>"
                                    ."<header class='modal-header'>"
                                        ."<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"
                                        ."<h4 class='modal-title'> ORDER DETAILS </h4>"
                                    ."</header>"
                                    ."<article class='modal-body>"
                                        ."<h3 class='accountpageh3'>";
                                        if ($shipped == 'Y') {
                                            echo "WE'VE SENT IT!! </h3>";
                                        }
                                        else {
                                            echo "WE'RE STILL PROCESSING YOUR ORDER.. </h3>";
                                        }
                                    echo "<p class='orderdescription'>ORDER NO.: $order_id </p>"
                                        ."<p class='orderdescription'>TOTAL PRICE: $order_total_price </p>"
                                        ."<p class='orderdescription orderline'>ORDER DATE: $order_date </p>"
                                        ."<section>";
                                        displayItemDetails($order_id);
                                    echo "</section> </article> </article> </article> </section> </section>";

                }
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
                $sql = "SELECT order_item.quantity, item.item_id, item.img_source, item.product_price, item.size, item.product_name, item.product_col from item, order_item, order_info where item.item_id = order_item.item_id and order_info.order_id = $order_id";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $item_id = $row['item_id'];
                    $img_source = $row['img_source'];
                    $product_col = $row['product_col'];
                    $size = $row['size'];
                    $product_name = $row['product_name'];
                    $qty = $row['quantity'];
                    $product_price = $row['product_price'];
                    echo "<figure class='containter-fluid ordericon' id='wrapper'>"
                        ."<a href='$product_col-php/$product_col$item_id.php'><img class='ordericon' src='$img_source' alt='$product_name'";
                    echo "<figcaption class='price text-center'>$product_name </figcaption>"
                        ."<h4 class='price text-center'>"
                        ."<span class='visible-xs visible visible-sm visible-md'>$product_price /pc </span>"
                        ."<span class='visible-xs visible visible-sm visible-md'>$size</span>"
                        ."<span class='visible-xs visible visible-sm visible-md'>$qty pc </span> </h4> </figure>";
                }
            }
        }
        

        // Display the images of order
        function displayOrderImages($order_id){
            $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME); //connect to database
            $errorMsg = "";
            $success = true;
            if ($conn->connect_error) {
                $errorMsg .= "Connection failed at displayOrderImagesByAccID: " .$conn->connect_error;
                $success = false;
            }
            
            else {
                $sql = "SELECT item.img_source, item.size, item.product_name from item, order_item, order_info where item.item_id = order_item.item_id and order_info.order_id = $order_id";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $img_source = $row['img_source'];
                    $size = $row['size'];
                    $product_name = $row['product_name'];
                    echo "<img class='ordericon' src='$img_source' alt='$product_name $size'";
                }
            }
        }

        
        
    


?>
             


        <article class='container-fluid accountcontainer'>
            <nav class="tab d-flex justify-content-center">
                <button class="tablinks" id='accountinfo'><span class="glyphicon glyphicon-user"></span>  Account Info</button>
                <button class="tablinks" id='orders'><span class="glyphicon glyphicon-shopping-cart"></span>  My Orders</button>
                <button class="tablinks" id='payment'><span class="glyphicon glyphicon-credit-card"></span>  Payment Methods</button>
            </nav>

            <figure id="default" class="defaulttab ">
                <img class="accountbackground" id='accountbackground' src="background.jpeg" alt="accountpicture" >
                <figcaption> 
                    <h3 class='accountbackgroundfont'>Hello <?php getName($session) ?>, 
                        Welcome to Your Account</h3>
                </figcaption>       
            </figure>
            <section id="accountinfo1" class="tabitems text-center">
                <h1 class="accountpageh1"><span class="glyphicon glyphicon-user"></span>  MY ACCOUNT INFO</h1>
                <p class="accountpagecaption">Feel free to edit any of the details so that your account is up to date</p>

                <form name='accountForm'>
                    <div class="accountinfo-form">
                        <label class="inputtitle">EMAIL :</label>
                        <input type="email" class="accountinfo-form-style" id="email" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" value="<?php echo $session ?>" >
                        <label class="inputtitle">NAME : </label>
                        <input type="text" class="accountinfo-form-style" id="firstname" pattern="[A-Za-z]{3,50}" value="<?php getName($session) ?>" >
                        <label class="inputtitle">PASSWORD : </label>
                        <input type="password" class="accountinfo-form-style" id="pw" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,15}$" value="" >
                        <button type="submit" class="btn1 btn-submit">Update Changes</button>
                    </div>                
                </form>
            </section>

            <section id="orders1" class="tabitems ">
                <h1 class="accountpageh1 text-center"><span class="glyphicon glyphicon-shopping-cart"></span>  MY ORDERS</h1>
                <p class="accountpagecaption text-center">An overall view of your past purchases</p>

                <article class="container-fluid ordercontainer">
<!--                    <section class='row text-center '>
                        <h3 class="accountpageh3">WE'VE SENT IT!!</h3>
                        <p class='orderdescription'>ORDER NO.: 00150001300</p>
                        <p class='orderdescription orderline'>SHIPPED DATE: 07 Oct, 2019</p>

                        <div>
                            <img class='ordericon' src='celestial-php/celestial-img/c1.png' alt='celestial1'>
                            <img class='ordericon' src='celestial-php/celestial-img/c2.png' alt='celestial2'>
                            <img class='ordericon' src='celestial-php/celestial-img/c3.png' alt='celestial3'>
                            <img class='ordericon' src='celestial-php/celestial-img/c4.png' alt='celestial4'>                    
                        </div>
                        <button type="button" class="btn1 btn-submit" data-toggle='modal' data-target="#orderModalPopup">VIEW ORDER</button>

                         Popup modal upon clicking VIEW ORDER 
                        <article class="orderModal fade text-center" id="orderModalPopup" tabindex="-1" role="dialog">
                            <article class="modal-dialog" role="document">
                                <article class="orderDetails-content">
                                    <header class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"> ORDER DETAILS </h4>
                                    </header>
                                    <article class="modal-body">
                                        <h3 class="accountpageh3">WE'VE SENT IT!!</h3>
                                        <p class='orderdescription'>ORDER NO.: 00150001300</p>
                                        <p class="orderdescription">ORDER DATE: 05 Oct, 2019</p>
                                        <p class='orderdescription orderline'>SHIPPED DATE: 07 Oct, 2019</p>

                                        <section>
                                            <figure class="container-fluid ordericon" id='wrapper'>  column for each item, to wrap the price inside
                                                <a href="celestial-html/celestial1.html"><img class="ordericon" src="celestial-html/celestial-img/c1.png" alt="mew"></a>
                                                <figcaption class="text-center">MEW</figcaption> 
                                                <figcaption class="price text-center">
                                                    <span class="visible-xs visible visible-sm visible-md">$29.00</span>
                                                    <span class="visible-xs visible visible-sm visible-md">XS</span>
                                                    <span class="visible-xs visible visible-sm visible-md">2 pc</span>
                                                </figcaption>  hover for hidden price
                                            </figure>

                                            <figure class="container-fluid ordericon" id='wrapper'>  column for each item, to wrap the price inside
                                                <a href="celestial-html/celestial2.html"><img class="ordericon" src="celestial-html/celestial-img/c2.png" alt="faceless ralts"></a>
                                                <figcaption class="text-center">FACELESS RALTS</figcaption> 
                                                <figcaption class="price text-center">
                                                    <span class="visible-xs visible visible-sm visible-md">$29.00</span>
                                                    <span class="visible-xs visible visible-sm visible-md">XS</span>
                                                    <span class="visible-xs visible visible-sm ">1 pc</span>                                            </figcaption>  hover for hidden price
                                            </figure>
                                            <figure class="container-fluid ordericon" id='wrapper'>  column for each item, to wrap the price inside
                                                <a href="celestial-html/celestial3.html"><img class="ordericon" src="celestial-html/celestial-img/c3.png" alt="manaphu"></a>
                                                <figcaption class="text-center">MANAPHY</figcaption> 
                                                <figcaption class="price text-center">
                                                    <span class="visible-xs visible visible-sm visible-md">$29.00</span>
                                                    <span class="visible-xs visible visible-sm visible-md">XS</span>
                                                    <span class="visible-xs visible visible-sm visible-md">1 pc</span>                                            </figcaption>  hover for hidden price
                                            </figure>
                                            <figure class="container-fluid ordericon" id='wrapper'>  column for each item, to wrap the price inside
                                                <a href="celestial-html/celestial4.html"><img class="ordericon" src="celestial-html/celestial-img/c4.png" alt="jirachi"></a>
                                                <figcaption class="text-center">MANAPHY</figcaption> 
                                                <figcaption class="price text-center">
                                                    <span class="visible-xs visible visible-sm visible-md">$29.00</span>
                                                    <span class="visible-xs visible visible-sm visible-md">XS</span>
                                                    <span class="visible-xs visible visible-sm visible-md">1 pc</span>                                            </figcaption>  hover for hidden price
                                            </figure>                                                                       
                                        </section>
                                    </article>
                                </article>
                            </article>
                        </article>
                    </section>-->
                    <?php displayOrderByAccID($acc_id); ?>
                </article>
            </section>

            <section id="payment1" class="tabitems text-center">
                <h1 class="accountpageh1"><span class="glyphicon glyphicon-credit-card"></span>  PAYMENT METHODS</h1>
                <button type="button" class="btn1 btn-addcard" data-toggle="modal" data-target="#paymentModalPopup">ADD NEW PAYMENT METHOD</button>


                <!-- Popup modal upon clicking ADD NEW PAYMENT METHOD button -->
                <article class="paymentModal fade text-center" id="paymentModalPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <article class="modal-dialog" role="form">
                        <form name='addPaymentForm' class="addpayment-content">
                            <header class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">ADD CARD</h4>
                            </header>
                            <section class="modal-body">
                                <label class="inputtitle">CARD NUMBER :</label>
                                <input type="text" class="addCardForm" id="card" pattern='^\d{16}$' value="" placeholder="Enter your Card No.">
                                <label for="exp-month" class="inputtitle">EXPIRY DATE</label>
                                <article class="ccForm-row">

                                    <select class="addCardForm ccForm" id="exp-day">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">29</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>


                                    </select>
                                    <select class="addCardForm ccForm" id="exp-month">
                                        <option value="1">JANUARY</option>
                                        <option value="2">FEBRUARY</option>
                                        <option value="3">MARCH</option>
                                        <option value="4">APRIL</option>
                                        <option value="5">MAY</option>
                                        <option value="6">JUNE</option>
                                        <option value="7">JULY</option>
                                        <option value="8">AUGUST</option>
                                        <option value="90">SEPTEMBER</option>
                                        <option value="10">OCTOBER</option>
                                        <option value="11">NOVEMBER</option>
                                        <option value="12">DECEMBER</option>

                                    </select>
                                </article>

                                <label class="inputtitle">NAME ON CARD :</label>
                                <input type="text" class="addCardForm" id="namecard" value="" placeholder="Enter your name on your card">

                            </section>
                            <footer class="modal-footer">
                                <button type="submit" class="btn1 btn-submit">Add Card</button>
                            </footer>
                        </form>
                    </article>
                </article>


            </section>

        </article>

        <footer class="container-fluid panel-footer text-center footer-color">
            <ul class="list-inline">
                <li><p>&copy; DELTA 2019</p></li>
                <li><a href="index.html">HOME</a></li>
                <li><a href="aboutus.html">ABOUT US</a></li>
                <li><a href="cartpage.html">CART</a></li>
            </ul>
        </footer>
    </body>

</html>
