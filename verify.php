<?php
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
ini.set('session.cookie_httponly', 1);

if (session_status() == PHP_SESSION_NONE){
    session_start();
} 

if (isset($_SESSION['acc_id'])) {
    header("Location:index.php");
    exit();
}

function verifyFunc() {
    $errorMsg = "";
    $success = true;

    if (!isset($_GET["verify_code"]) || !isset($_GET["email"])) {
        $errorMsg .= "Invalid Verification.<br>";
        $success = false;
    } else {
        $verify_code = $_GET["verify_code"];
        $email = $_GET["email"];

        include 'dbcon.inc.php';
        $checkacc = $conn->prepare("SELECT * FROM account WHERE email = ? AND acc_verify_code = ?");
        $checkacc->bind_param('ss', $email, $verify_code);
        $checkacc->execute();
        $results = $checkacc->get_result();

        if ($results->num_rows == 1) {
            $verifiedsuccess = 'Y';
            $updateverification = $conn->prepare("UPDATE account SET acc_verified = ? WHERE email = ? AND acc_verify_code = ?");
            $updateverification->bind_param('sss', $verifiedsuccess, $email, $verify_code);
            $updateverification->execute();
        } else {
            $errorMsg .= "Invalid Verification.<br>";
            $success = false;
        }
        $results->free_result();
        $conn->close();
    }

    if ($success) {
        echo "<section class=\"middle\">";
        echo "<h1>Email: " . $email . " has been verified!</h1>";
        echo "</section>";
    } else {
        echo "<section class=\"middle\">";
        echo "<h1>The following errors were detected:</h1>";
        echo "<p>" . $errorMsg . "</p>";
        echo "</section>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DELTA - VERIFICATION</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Top 1 self-designed fashion in Singapore">
        <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.css"> 
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/errorstyling.css">
    </head>

    <body>
        <?php
        include 'header.inc.php';
        ?>
        <main>
            <?php
            verifyFunc();
            ?>
        </main>
        <?php
        include 'footer.inc.php';
        ?>
    </body>
</html>





