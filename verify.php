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
</html>

<?php
include 'header.inc.php';
$errorMsg = "";
$success = true;

if (!isset($_GET["verify_code"]) || !isset($_GET["email"])) {
    $errorMsg .= "Invalid Verification.<br>";
    $success = false;
} else {
    $verify_code = $_GET["verify_code"];
    $email = $_GET["email"];

    include 'dbcon.inc.php';
    $checkacc = ("SELECT * FROM account WHERE email = '$email' AND acc_verify_code = '$verify_code'");
    $results = $conn->query($checkacc);

    if ($results->num_rows == 1) {
        $verifiedsuccess = 'Y';
        $updateverification = ("UPDATE account SET acc_verified = '$verifiedsuccess' WHERE email = '$email' "
                . "AND acc_verify_code = '$verify_code'");
        $conn->query($updateverification);
    } else {
        $errorMsg .= "Invalid Verification.<br>";
        $success = false;
    }
    $results->free_result();
    $conn->close();

    
}

if ($success) {
        echo "<section class=\"middle\">";
        echo "<h4>Email: " . $email . " has been verified!</h4>";
        echo "</section>";
    } else {
        echo "<section class=\"middle\">";
        echo "<h4>The following errors were detected:</h4>";
        echo "<p>" . $errorMsg . "</p>";
        echo "</section>";
    }

include 'footer.inc.php';
?>

