<?php
include '../session.php';
include '../dbcon.php';

function getdata($id)
{
    //Create connection
    $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    //define variables and set to empty values
    $img_source = $pname = $price = $db_error_msg = "";
    $success = true;

    if ($conn->connect_error) {
        $db_error_msg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $collection = 'celestial';
        $stmt = $conn->prepare("SELECT img_source, product_desc, product_name, product_price FROM item WHERE product_col = ? AND item_id = ?;");
        $stmt->bind_param('si', $collection, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        $result->free_result();
        $conn->close();

        if (isset($row)) {
            $img_source = $row['img_source'];
            $pname = $row['product_name'];
            $price = $row['product_price'];
        }

        unset($result, $row);

        echo "<figure class = 'col-sm-3' id = 'wrapper'>";
        echo "<a href = 'celestial$id.php'><img class = 'imgzoom product-img img-responsive hover' src = '$img_source' alt = '$pname'></a>";
        echo "<figcaption class = 'text-center'>$pname</figcaption>";
        echo "<figcaption class = 'price text-center'>&dollar;$price</figcaption><!--hover for hidden price-->";
        echo "</figure>";
    }
}
?>

<html>

<head>
    <title>DELTA - CELESTIAL</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Top 1 self-designed fashion in Singapore">
    <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Varela&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/collections.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['user'])) {
        include($_SERVER['DOCUMENT_ROOT'] . '/ict1004-project/header.php');
    } else {
        include($_SERVER['DOCUMENT_ROOT'] . '/ict1004-project/headerin.php');
        $session = $_SESSION['user'];
        //echo "<script type='text/javascript'>alert('{$_SESSION}'.'<br />');</script>";
        echo ("{$_SESSION['user']}" . "<br />");
    }
    ?>

    <section class="container">
        <!-- 1 row for 1st 4 items-->
        <article class="row">
            <!--must text center-->
            <h1 class="text-center">CELESTIAL</h1>
            <!-- column for each item, to wrap the price inside-->
            <?php getdata(1); ?>
            <?php getdata(4); ?>
            <?php getdata(7); ?>
            <?php getdata(10); ?>
        </article>

        <!-- 1 row for next 4 items, top-buffer to create space in between-->
        <article class="row top-buffer">
            <?php getdata(13); ?>
            <?php getdata(16); ?>
            <?php getdata(19); ?>
            <?php getdata(22); ?>
        </article>
    </section>

    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/ict1004-project/footer.php')
    ?>
</body>

</html>