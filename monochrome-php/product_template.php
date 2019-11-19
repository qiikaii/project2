<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../dbcon.inc.php';

//define variables and set to empty values
$img_source = $pname = $price = $desc = $db_error_msg = "";
$success = true;

if ($conn->connect_error) {
    $db_error_msg = "Connection failed: " . $conn->connect_error;
    $success = false;
} else {
    $stmt = $conn->prepare("SELECT * FROM item WHERE product_col = ? AND item_id = ?;");
    $stmt->bind_param('si', $col_name, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);
    $result->free_result();
    $conn->close();

    if (isset($row)) {
        $product_id = $row['item_id'];
        $img_source = $row['img_source'];
        $pname = $row['product_name'];
        $price = $row['product_price'];
        $desc = $row['product_desc'];
    }

    unset($result, $row);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>DELTA - <?php echo $pname; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Top 1 self-designed fashion in Singapore">
    <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
    <script src="../js/jquery.magnify.js"></script>
    <script src="../js/jquery.magnify-mobile.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/singleproduct.js"></script>
    <link rel="stylesheet" href="../css/singleproduct.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
    <?php
    include 'header.inc.php';
    ?>
    <main>
        <section class="container">
            <!--1 column for image-->
            <figure class='col-md-6 single-prod-buffer'>
                <img class="single-img zoom img-responsive" data-magnify-src=<?php echo "$img_source"; ?> src=<?php echo "$img_source"; ?> alt="Product design for <?php echo "$pname"; ?>">
            </figure>

            <!-- 1 column for text-->
            <section class="col-md-6">
                <!--1 row within text column for heading and dropdown forms-->
                <section class="row">
                    <article class="form-group text-center">
                        <h1><?php echo "$pname"; ?></h1>
                        <h2>&dollar;<?php echo "$price"; ?></h2>
                        <!-- form for size and quantity-->
                        <form action="<?php echo htmlspecialchars('../process_cart.php') ?>" id="cart-form" name="cart-form" method="post" onsubmit="validateInput(event)">
                            <label class="top-buffer" for="size_options">SIZE</label>
                            <select name="size" class="size-form-control" id="size_options">
                                <option value='S'>SMALL</option>
                                <option value='M'>MEDIUM</option>
                                <option value='L'>LARGE</option>
                            </select>

                            <label class="top-buffer" for="quantity_options">QUANTITY</label>
                            <select name="quantity" class="size-form-control" id="quantity_options">
                                <option value='1'>1</option>
                                <option value='2'>2</option>
                                <option value='3'>3</option>
                                <option value='4'>4</option>
                                <option value='5'>5</option>
                                <option value='6'>6</option>
                                <option value='7'>7</option>
                                <option value='8'>8</option>
                                <option value='9'>9</option>
                                <option value='10'>10</option>
                            </select>
                            <input class="cart-button" type="submit" form="cart-form" name="add_cart" value="Add To Cart" />
                            <input type="hidden" name="product_id" value=<?php echo "$product_id"; ?>>
                        </form>

                        <!--1 row for toggle tabs-->
                        <section class="row top-buffer">
                            <!--whole tab-->
                            <article class="text-center tablist-detail">
                                <section class="tab-buttons">
                                    <ul class="nav nav-tabs device-small">
                                        <li class="active"><a data-toggle="tab" href="#size">Size</a></li>
                                        <li><a data-toggle="tab" href="#details">Details</a></li>
                                        <li><a data-toggle="tab" href="#shipping">Shipping</a></li>
                                        <li><a data-toggle="tab" href="#returns">Returns</a></li>
                                    </ul>
                                </section>
                                <section class="tab-content">
                                    <!--for sizing tab-->
                                    <article id="size" class="tab-pane fade in active">
                                        <!--sizing table-->
                                        <table class="table-details">
                                            <thead>
                                                <tr>
                                                    <th>Size(cm)</th>
                                                    <th>S</th>
                                                    <th>M</th>
                                                    <th>L</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Length</td>
                                                    <td>65.5</td>
                                                    <td>69.5</td>
                                                    <td>72.5</td>
                                                </tr>
                                                <tr>
                                                    <td>Chest</td>
                                                    <td>48</td>
                                                    <td>49.5</td>
                                                    <td>53.5</td>
                                                </tr>
                                                <tr>
                                                    <td>Sleeve</td>
                                                    <td>18.5</td>
                                                    <td>19.5</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td>Shoulder</td>
                                                    <td>40.5</td>
                                                    <td>44.5</td>
                                                    <td>46</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </article>


                                    <!--details tab-->
                                    <article id="details" class="device-small tab-pane fade">
                                        <p><?php echo "$desc" ?></p>
                                    </article>

                                    <!--shipping tab-->
                                    <article id="shipping" class="device-small tab-pane fade">
                                        Free shipping on orders of SGD50 and over.
                                        <br>
                                        Orders under SGD50 ships for SGD5.
                                    </article>

                                    <!--returns tab-->
                                    <article id="returns" class="device-small tab-pane fade">
                                        <p>In general returns for size exchanges or refunds are not accepted. If the item is defected, contact us at delta@email.com - we'll make things right.</p>
                                    </article>
                                </section>
                            </article>
                        </section>
                    </article>
                </section>
            </section>
        </section>
    </main>
    <?php
    include 'footer.inc.php'
    ?>
</body>

</html>