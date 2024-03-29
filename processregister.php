<?php
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);

if (session_status() == PHP_SESSION_NONE){
    session_start();
} 
if (isset($_SESSION['acc_id'])) {
    header("Location:index.php");
    exit();
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function processRegisterFunc() {
    $errorMsg = $name = $email = $pwd = $pwd1 = "";
    $success = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["regibutton"])) {
            if (empty($_POST["regiemail"])) {
                $errorMsg .= "Email is required.<br>";
                $success = false;
            } else {
                $email = sanitize_input($_POST["regiemail"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errorMsg .= "Invalid email format.<br>";
                    $success = false;
                } else if (!preg_match('/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/', $email)) {
                    $errorMsg .= "Invalid email format.<br>";
                    $success = false;
                }

                include 'dbcon.inc.php';
                $checkemail = ("SELECT email FROM account WHERE email = '$email'");
                $result = $conn->query($checkemail);
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } else {
                    if ($result->num_rows == 1) {
                        $conn->close();
                        $result->free_result();
                        $errorMsg = "Email has been registered before.<br>";
                        $success = false;
                    }
                }
            }

            if (empty($_POST["reginame"])) {
                $errorMsg .= "Name is required.<br>";
                $success = false;
            } else {
                $name = sanitize_input($_POST["reginame"]);
                if (!preg_match('/^[a-zA-Z]+( [a-zA-Z]+)*$/', $name)) {
                    $errorMsg .= "Invalid name format.<br>";
                    $success = false;
                }
            }

            if (empty($_POST['regipass'])) {
                $errorMsg .= "Password is required.<br>";
                $success = false;
            } else {
                $pwd = sanitize_input($_POST["regipass"]);
                if (!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}/', $pwd)) {
                    $errorMsg .= "Invalid password format.<br>";
                    $success = false;
                }
            }

            if (empty($_POST['regiconpass'])) {
                $errorMsg .= "Confirm password is required. <br>";
                $success = false;
            } else {
                $pwd1 = sanitize_input($_POST["regiconpass"]);
                if (!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}/', $pwd)) {
                    $errorMsg .= "Invalid confirm password format.<br>";
                    $success = false;
                }
            }

            if ($pwd != $pwd1) {
                $errorMsg .= "Password are not the same.<br>";
                $success = false;
            }

            if ($success == true) {
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } else {
                    $existacc_id = true;
                    do {
                        $acc_id = mt_rand(1, 99999999);
                        $checkacc_id = $conn->prepare("SELECT acc_id FROM account WHERE acc_id = ?");
                        $checkacc_id->bind_param('d', $acc_id);
                        $checkacc_id->execute();
                        $results = $checkacc_id->get_result();
                        
                        if ($results->num_rows == 1) {
                            $existacc_id = true;
                        } else {
                            $acc_verified = 'N';
                            $acc_verify_code = substr(md5(uniqid(rand(), true)), 16, 16);
                            $pwd = password_hash($pwd, PASSWORD_BCRYPT);
                            $attempts = 0;
                            $unlock_time = null;
                            $sql = $conn->prepare("INSERT INTO account (acc_id, email, name, password, acc_verified, acc_verify_code, attempts, unlock_time) "
                                    . "VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                            $sql->bind_param('isssssis', $acc_id, $email, $name, $pwd, $acc_verified, $acc_verify_code, $attempts, $unlock_time);
                            $sql->execute();
                            $conn->close();

                            require("class.phpmailer.inc.php");
                            require("class.smtp.inc.php");

                            $mail = new PHPMailer();
                            $mail->SMTPDebug = 1;
                            $mail->IsSMTP();
                            $mail->Host = "smtp.gmail.com";
                            $mail->Port = 587;
                            $mail->SMTPAuth = true;
                            $mail->Username = "DeltaatSIT@gmail.com";
                            $mail->Password = "DeltaSIT1!";

                            $mail->From = "DeltaatSIT@gmail.com";
                            $mail->FromName = "Delta @ SIT";
                            $mail->AddAddress($email);
                            $mail->WordWrap = 50;
                            $mail->IsHTML(true);
                            $mail->SMTPSecure = 'tls';

                            $mail->Subject = "Verification of Delta @ SIT Account";
                            $mail->Body = "Dear $name, <br><br>
		Please proceed to the url below to verify your account. <br>
		<a href=\"http://ict1004.ddns.net/AY19/P2-3/project2/verify.php?email=$email&verify_code=$acc_verify_code\">
		Click on this link to verify your account.</a><br><br>
		
		Thank you.<br>
		Delta @ SIT";

                            $mail->AltBody = "Dear $name, <br><br>
		Please proceed to the url below to verify your account. <br>
		<a href=\"http://ict1004.ddns.net/AY19/P2-3/project2/verify.php?email=$email&verify_code=$acc_verify_code\">
		Click on this link to verify your account.</a><br><br>
		
		Thank you.<br>
		Delta @ SIT";

                            $mail->Send();

                            echo "<section class=\"middle\">
                <h1>Registration successful!</h1>
                <p>Please verify your account at your email: $email
                </section>";
                            $existacc_id = false;
                        }
                    } while ($existacc_id == true);
                }
            }
        } else {
            $errorMsg = "Please submit the form from the register page.<br>";
            $success = false;
        }
    } else {
        $errorMsg = "Please submit the form from the register page.<br>";
        $success = false;
    }

    if (!$success) {
        echo "<section class=\"middle\">
    <h1>The following input errors were detected:</h1>
    <p> $errorMsg </p>
    </section>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DELTA - REGISTER</title>
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
            processRegisterFunc();
            ?>
        </main>
        <?php
        include 'footer.inc.php';
        ?>
    </body>
</html> 

