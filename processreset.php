<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DELTA - RESET PASSWORD</title>
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
$errorMsg = $name = $email = "";
$success = true;

if ($_SERVER_REQUEST["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["resetbutton"])) {
        if (empty($_POST["resetname"])) {
            $errorMsg .= "Name is required.<br>";
            $success = false;
        } else {
            $name = sanitize_input($_POST["resetname"]);
            if (!preg_match('/^(?=^[A-Za-z]+\s?[A-Za-z]+$).{3,}$/', $name)) {
                $errorMsg .= "Invalid name format.<br>";
                $success = false;
            }
        }

        if (empty($_POST["resetemail"])) {
            $errorMsg .= "Email is required.<br>";
            $success = false;
        } else {
            $email = sanitize_input($_POST["resetemail"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMsg .= "Invalid email format.<br>";
                $success = false;
            } else if (!preg_match('/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/', $email)) {
                $errorMsg .= "Invalid email format.<br>";
                $success = false;
            }
        }

        if ($success == true) {
            include 'dbcon.inc.php';
            if ($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            } else {
                $sql = "SELECT * FROM account WHERE name='$name' AND email = '$email'";
                $result = $conn->query($sql);

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $result->free_result();

                    require 'generatepass.php';
                    $resetpwd = generateStrongPassword($length = 8, $add_dashes = false, $available_sets = 'luds');
                    $displaypwd = $resetpwd;
                    $resetpwd = password_hash($resetpwd, PASSWORD_BCRYPT);
                    $sql = "UPDATE account SET password = '$displaypwd' WHERE name = '$name' AND email = '$email'";
                    $result = $conn->query($sql);
                    $conn->close();

                    require("class.phpmailer.php");
                    require("class.smtp.php");

                    $mail = new PHPMailer();
                    $mail->SMTPDebug = 1;
                    $mail->IsSMTP();
                    $mail->Host = "smtp.gmail.com";
                    $mail->Port = 587;
                    $mail->SMTPAuth = true;
                    $mail->Username = "XbatbatX@gmail.com";
                    $mail->Password = "P@5sword";

                    $mail->From = "DeltaatSIT@gmail.com";
                    $mail->FromName = "Delta @ SIT";
                    $mail->AddAddress($email);
                    $mail->WordWrap = 50;
                    $mail->IsHTML(true);
                    $mail->SMTPSecure = 'tls';

                    $mail->Subject = "Reset Password of Delta @ SIT Account";
                    $mail->Body = "Dear $name, <br><br>
		Your password has been changed to: $displaypwd<br>
		Please log in to change your password<br><br>
		
		Thank you.<br>
		Delta @ SIT";

                    $mail->AltBody = "Dear $name, <br><br>
		Your password has been changed to: $displaypwd<br>
		Please log in to change your password<br><br>
		
		Thank you.<br>
		Delta @ SIT";

                    $mail->Send();

                    echo "<section class=\"middle\">
                <h4>Reset password successful!</h4>
                <p>Your password has been reset and sent to your email: $email
                </section>";
                } else {
                    $errorMsg = "Email not found or name doesn't match.<br>";
                    $success = false;
                    $conn->close();
                }
            }
        }
    } else {
        $errorMsg = "Please submit the form from the reset page.<br>";
        $success = false;
    }
} else {
    $errorMsg = "Please submit the form from the reset page.<br>";
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

include 'footer.inc.php';
?>