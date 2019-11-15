<html>
    <title>DELTA</title>
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

</html>

<?php
include 'header.php';
$errorMsg = "";
$success = true;

 if (session_status() == PHP_SESSION_NONE){
    session_start();
}        

$session = $_SESSION['email']; // Email
$acc_id = $_SESSION['acc_id']; // Account_ID

if (isset($_POST["updatepwd"])) {
    if (empty($_POST["pwd"])) {
        $errorMsg .= "Password is required.<br>";
        $success = false;
    } 
    else {
        $pwd = sanitize_input($_POST["pwd"]);

         if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,15}$/', $pwd)) {
            $errorMsg .= "Input: Password has an invalid format<br>";
            $success = false;
        }

    }

    if (empty($_POST["newpwd"])) {
        $errorMsg .= "New password is required.<br>";
        $success = false;
    }
    
    else {
        $newpwd = sanitize_input($_POST["newpwd"]);
         if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,15}$/', $newpwd)) {
            $errorMsg .= "Input: New Password has an invalid format<br>";
            $success = false;
        }

    }

    if (empty($_POST["cfmnewpwd"])) {
        $errorMsg .= "Confirm new password is required.<br>";
        $success = false;
    }
    
    else {
        $cfmnewpwd = sanitize_input($_POST["cfmnewpwd"]);
         if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,15}$/', $cfmnewpwd)) {
            $errorMsg .= "Input: Confirm new password has an invalid format<br>";
            $success = false;
        }

    }

    if ($newpwd != $cfmnewpwd) {
        $errorMsg .= "New Password and Confirm New Password must be the same.<br>";
        $success = false;
    }
    
    if ($newpwd == $pwd || $cfmnewpwd == $pwd) {
        $errorMsg .= "New password must not be same as old password!<br>";
        $success = false;       
    }
    

    if ($success == true){
        include 'dbcon.php';
        if ($conn->connect_error) {
            $errorMsg .= "Connection Failed: " . $conn->connect_error;
            $success = false;
        }
        
        else {
            $sql = ("SELECT * FROM account WHERE acc_id = '$acc_id'");
            $results = $conn->query($sql);
            if ($results->num_rows == 1){
                $row = $results->fetch_assoc();
                $results->free_result();
                $conn->close();
                if (password_verify($pwd, $row['password']) == false){
                    $errorMsg .= "Wrong Password. Please retype password. " .$conn->connect_error;
                    $success = false;
                }
                else {
                    updatepw($cfmnewpwd, $session, $acc_id);    
                }
                
            }
            
            else {
                $errorMsg .= "Wrong Password. Please retype password." . $conn->connect_error;
                $success = false;
            }
        }
    }
}
    
else {
    $errorMsg = "Please submit the form from the register page.<br>";
    $success = false;
}

function updatepw($cfmnewpwd, $session, $acc_id){
    $errorMsg = "";
    $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME); //connect to database
    if ($conn->connect_error) {
        $errorMsg .= "Connection failed at updatepw()" . $conn->connect_error;
        $success = false;
    }
    else {
        $cfmnewpwd = password_hash($cfmnewpwd, PASSWORD_BCRYPT);
        $sql = ("UPDATE account SET password = '$cfmnewpwd' WHERE email = '$session' and acc_id = '$acc_id' ");
        $result = $conn->query($sql);
        $conn->close();

        echo "<section class=\"middle\">
        <h4>Update password successful!</h4>
        <p>Please relogin your account</p>
        <p> Redirecting you to login page in.. ); 
        </section>";
         header( 'refresh:3; url=logout.php');
    }
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

include 'footer.php';

?>