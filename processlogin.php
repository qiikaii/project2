<html>
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
    <!-- Prevent ClickJacking -->
    <meta http-equiv="X-Frame-Options" content="deny">
</html>

<?php
include 'header.php';
$errorMsg = $pwd = $email = "";
$success = true;

if (empty($_POST["loginemail"])) {
    $errorMsg .= "Email is required.<br>";
    $success = false;
} else {
    $email = sanitize_input($_POST["loginemail"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg .= "Invalid email format.<br>";
        $success = false;
    } else if (!preg_match('/[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$/', $email)) {
        $errorMsg .= "Invalid email format.<br>";
        $success = false;
    }
}

if (empty($_POST["loginpass"])) {
    $errorMsg .= "Password is required.<br>";
    $success = false;
} else {
    $pwd = sanitize_input($_POST["loginpass"]);
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,15}$/', $pwd)) {
        $errorMsg .= "Invalid password format.<br>";
        $success = false;
    }
}

if ($success == true) {
    include 'dbcon.php';
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $sql = "SELECT * FROM account WHERE email = '$email' AND password = '$pwd'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $conn->close();
            $result->free_result();
            if ($row["acc_verified"] != 'Y') {
                $errorMsg = "Account not verified yet.<br>";
                $success = false;
            } else {
                session_start();
                $_SESSION['acc_id'] = $row['acc_id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];

                header("location:account.php");
            }
        } else {
            $errorMsg = "Email not found or password doesn't match.<br>";
            $success = false;
            $conn->close();
        }
    }
}

if (!$success) {
    echo "<section class=\"middle\">
    <h4>The following input errors were detected:</h4>
    <p> $errorMsg </p>
    </section>";
}

    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    include 'footer.php';
    ?>