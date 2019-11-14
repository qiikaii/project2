<!DOCTYPE html>
<html>
    <head>
        <title>DELTA - LOGIN PAGE</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Top 1 self-designed fashion in Singapore">
        <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.css"> 
        <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/loginpage.css">
        <!-- Insert Google ReCaptcha -->
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <!-- Prevent ClickJacking -->
   	<meta http-equiv="X-Frame-Options" content="deny">
    </head>

    <body>
        <?php
        include 'header.php';
        ?>    

        <!-- Nav Tabs Bar -->
        <section class="containrow">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#login">SIGN-IN</a></li>
                <li><a data-toggle="tab" href="#register">REGISTER</a></li>
                <li><a data-toggle="tab" href="#resetpass">FORGOT YOUR PASSWORD?</a></li>
            </ul>
            <article class="tab-content">
                <!-- Login Body -->
                <section id="login" class="tab-pane fade in active">
                    <article class="loginbody">
                        <h2 class="maintitle">SIGN-IN</h2>
                        <form name="loginform" action="<?php echo htmlspecialchars("processlogin.php");?>" method="post">
                            <label for="email" class="separator">Email:</label>
                            <input class="separator" name="loginemail" type="email" placeholder="Log in with your Email" 
                                   size="60" maxlength="100" autocomplete="off"/>
                            <label for="password" class="separator">Password:</label>
                            <input class="separator" name="loginpass" type="password" placeholder="Enter your Password" 
                                   size="60" maxlength="100" autocomplete="off"
                                   title="Must contain at least 1 uppercase, 1 lowercase and 1 number/special character.">
                            <section class="separator">
                                <!--<article class="g-recaptcha" data-sitekey="6Ld16RYTAAAAAHYoqPeGafdXADe1ya7vEuXj871m">
                                </article>-->
                            </section>
                            <button class="loginbutton" name="loginbutton">LOGIN</a></button>
                            <p class="separatorlink">——————— Already have an account? Sign In! ———————</p>
                        </form>
                    </article>
                </section>


                <!-- Register Body -->
                <section id="register" class="tab-pane fade">
                    <article class="regibody">
                        <h2 class="maintitle">REGISTER</h2>
                        <form name="registerform" action="<?php echo htmlspecialchars("processregister.php");?>" method="post">
                            <label for="reginame" class="separator">Name:</label>
                            <input class="separator" name="reginame" type="text" 
                                   placeholder="How do you want us to address you?" size="60" maxlength="100" autocomplete="off"
                                    />
                            <label for="regiemail" class="separator">Email:</label>
                            <input class="separator" name="regiemail" type="email" 
                                   placeholder="At least 8 alphanumeric characters." size="60" maxlength="100" autocomplete="off"
                                    />
                            <label for="regipass" class="separator">Password:</label>
                            <input class="separator" name="regipass" type="password" 
                                   placeholder="Keep your password confidential!" size="60" maxlength="100" autocomplete="off"
                                   title="Must contain at least 1 uppercase, 1 lowercase and 1 number/special character."
                                   />
                            <label for="regiconpass" class="separator">Confirm Password:</label> 
                            <input class="separator" name="regiconpass" type="password" 
                                   placeholder="Key in your password again." size="60" maxlength="100" autocomplete="off"
                                   title="Must contain at least 1 uppercase, 1 lowercase and 1 number/special character." 
                                   />
                            <section class="separator">
                                <!--<article class="g-recaptcha" data-sitekey="6Ld16RYTAAAAAHYoqPeGafdXADe1ya7vEuXj871m">
                                </article>-->
                            </section>
                            <button class="regibutton" value="regibutton">REGISTER</button>
                            <p class="separatorlink">—————————— New to Delta? Join us! ——————————</p>
                        </form>
                    </article>
                </section>

                <!-- Reset Pass Body -->
                <section id="resetpass" class="tab-pane fade">
                    <article class="resetbody">
                        <h2 class="maintitle">RESET PASSWORD</h2>
                        <form name="resetform" action="<?php echo htmlspecialchars("processreset.php");?>" method="post">
                            <label for="resetname" class="separator">Full Name:</label>
                            <input class="separator" name="resetname" type="text" 
                                   placeholder="Enter Full Name" size="60" maxlength="70" autocomplete="off"/>
                            <label for="resetemail" class="separator">Email:</label>
                            <input class="separator" name="resetemail" type="email" 
                                   placeholder="Enter your Email Address" size="60" maxlength="100" autocomplete="off"/>
                            <section class="separator">
                                <!--<article class="g-recaptcha" data-sitekey="6Ld16RYTAAAAAHYoqPeGafdXADe1ya7vEuXj871m">
                                </article>-->
                            </section>
                            <button class="resetbutton" value="resetbutton">RESET PASSWORD</button>
                        </form>
                    </article>
                </section>
            </article>
        </section>

        <!-- FOOTER -->
        <?php
        include 'footer.php';
        ?>
        <script src="js/validregister.js" type="text/javascript"></script>
        <script src="js/validlogin.js" type="text/javascript"></script>
    </body>
</html>