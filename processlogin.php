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

function processLoginFunc() {
    $errorMsg = $pwd = $email = "";
    $success = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["loginbutton"])) {
            if (empty($_POST["loginemail"])) {
                $errorMsg .= "Email is required.<br>";
                $success = false;
            } else {
                $email = sanitize_input($_POST["loginemail"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errorMsg .= "Invalid email format.<br>";
                    $success = false;
                } else if (!preg_match('/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/', $email)) {
                    $errorMsg .= "Invalid email format.<br>";
                    $success = false;
                }
            }

            if (empty($_POST["loginpass"])) {
                $errorMsg .= "Password is required.<br>";
                $success = false;
            } else {
                $pwd = sanitize_input($_POST["loginpass"]);
                if (!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}/', $pwd)) {
                    $errorMsg .= "Invalid password format.<br>";
                    $success = false;
                }
            }

            if ($success == true) {
                include 'dbcon.inc.php';
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } else {
                    $sql = $conn->prepare("SELECT * FROM account WHERE email = ?");
                    $sql->bind_param('s', $email);
                    $sql->execute();
                    $result = $sql->get_result();

                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        $conn->close();
                        $result->free_result();
                        if ($row["acc_verified"] != 'Y') {
                            $errorMsg = "Account not verified yet.<br>";
                            $success = false;
                        }
                        else {
                            if ($row['attempts'] >= 5) {
                                $errorMsg .= "Account locked out";
                                $current_time = date('Y-m-d H:i:s');

                                $unlock_time = date('Y-m-d H:i:s', strtotime($current_time . '+ 1 days'));
                                $attempts = 0;
                                $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
                                $sql = $conn->prepare("UPDATE account SET unlock_time = ?, attempts = ? where email = ?");
                                $sql->bind_param('sds', $unlock_time, $attempts, $email);
                                $sql->execute();
                                $conn->close();
                                $success = false;
                            }
                            else {
                                if (password_verify($pwd, $row['password']) == false) {
                                    $attempts = $row['attempts'];
                                    $attempts += 1;
                                    $triesleft = 5 - $attempts;
                                    $errorMsg .= "Email not found or password doesn't match.<br> You have " . $triesleft . " number of tries left";
                                    $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
                                    $sql = $conn->prepare("UPDATE account SET attempts = ? where email = ?");
                                    $sql->bind_param('is', $attempts, $email);
                                    $sql->execute();
                                    $conn->close();
                                    $success = false;
                                }
                                if ($row['unlock_time'] > date('Y-m-d H:i:s')) {
                                    $errorMsg .= "Account locked out";
                                    $success = false;
                                }
                                else if (password_verify($pwd, $row['password']) == true && $row['unlock_time'] <= date('Y-m-d H:i:s')) {
                                    session_regenerate_id();
                                    // Generate session values
                                    $_SESSION['auth'] = true;
                                    $_SESSION['acc_id'] = $row['acc_id'];
                                    $_SESSION['email'] = $row['email'];
                                    $_SESSION['name'] = $row['name'];
                                    // QK set session activity to time
                                    // It will expire after 30 minutes of inactivity
                                    // Header.php will check for activity status
                                    // Time compared to server time, so definitely secured
                                    $_SESSION['activity'] = time(); 
                                    $attempts = 0; // Reset number of attempts to 0 if login successfully
                                    $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
                                    $sql = $conn->prepare("UPDATE account SET attempts = ? where email = ?");
                                    $sql->bind_param('is', $attempts, $email);
                                    $sql->execute();
                                    $conn->close();
                                    
                                    
                                    // For Session Hijacking purposes
                                    // Check for root of client ip address, even if client uses
                                    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                                        $_SESSION['ip'] = $_SERVER['HTTP_CLIENT_IP'];
                                    }

                                    else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                                        $_SESSION['ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                    }

                                    else {
                                        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                                    }
                                    
                                    // Get user agent for comparison
                                    $_SESSION['browser'] = get_browser();
                                    header("location:account.php");
                                }
                            }
                        }
                    } 
                    else {
                        $errorMsg = "Email not found or password doesn't match.<br>";

                        $success = false;
                        $conn->close();
                    }
                }
            }
        } else {
            $errorMsg = "Please submit the form from the login page.<br>";
            $success = false;
        }
    } else {
        $errorMsg = "Please submit the form from the login page.<br>";
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
        <title>DELTA - LOGIN</title>
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
            processLoginFunc();
            ?>
        </main>
        <?php
        include 'footer.inc.php';
        ?>
    </body>
</html>
