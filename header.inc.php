<?php 

// If theres session and last activity is 30 minutes ago, then logout
if (isset($_SESSION['activity']) && (time() - $_SESSION['activity'] >= 1800)){
    header("location:logout.php");
}

// If theres session, echo out session for debugging
if (isset($_SESSION['activity'])) {
    echo $_SESSION['activity'];
}

else if (isset($_SESSION['activity']) && (time() - $_SESSION['activity'] < 1800)){
    $_SESSION['activity'] = time();
}

echo session_id();

?>

<script>
    console.log("%cSTOP", "color: red; font-size: 150px");
    console.log("%cThis is a browser feature intended for developers. ", "color= black; font-size=25px");
    console.log("%cIf someone told you to copy-paste something here to enable features or 'hack' someone's account, it is a scam and will give them access to your account.", "color= black; font-size=25px");
    console.log("%cSee https://en.wikipedia.org/wiki/Self-XSS for more information. ", "color= black; font-size=25px");
    response.setHeader("Set-Cookie", "HttpOnly;Secure;SameSite=Strict");
</script>

<header>
    <nav class="navbar navbar-expand-lg" id='header' role="navigation" aria-label="Primary">
        <nav class="navbar-header" role="navigation" aria-label="Secondary">
            <a class="navbar-brand" href="index.php">
                <img class="logo" src="logo.jpeg" alt="logo">
            </a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navresponsive">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </nav>
        <nav class="collapse navbar-collapse pull-right" id="navresponsive">
            <ul class="nav navbar-nav mainnavigation">
                <li class="nav-item"><a href="aboutus.php">ABOUT US</a></li>
                <li class="dropdown wrapper nav-item"><a class="dropdown-toggle" data-toggle="collapse" data-target="#dropdownlist" href="#">COLLECTIONS</a>
                    <ul class="dropdown-menu  dropdown-font" id="dropdownlist">
                        <li class="space"><a href="/project2/celestial-php/celestial.php">CELESTIAL</a></li>
                        <li class="space"><a href="/project2/monochrome-php/monochrome.php">MONOCHROME</a></li>
                    </ul>
                </li>
                <?php
                if (isset($_SESSION['acc_id'])) {
                echo "<li class=\"nav-item\"><a href=\"/project2/cartpage.php\">CART</a></li>                    
                <li class=\"nav-item\"><a href=\"/project2/logout.php\"><span class=\"glyphicon glyphicon-log-out\"></span> LOGOUT</a></li>";
                }
                else {
                echo "<li class=\"nav-item\"><a href=\"/project2/loginpage.php\"><span class=\"glyphicon glyphicon-log-in\"></span> LOGIN</a></li>";
                
                }
                ?>
            </ul>
        </nav>
    </nav>
</header>