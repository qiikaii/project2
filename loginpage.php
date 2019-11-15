<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DELTA - LOGIN PAGE</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Top 1 self-designed fashion in Singapore">
        <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.css"> 
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/loginpage.css">
        <!-- Insert Google ReCaptcha -->
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>

    <main>
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
                        <h1 class="maintitle">SIGN-IN</h1>
                        <form name="loginform" action="<?php echo htmlspecialchars("processlogin.php");?>" method="post">
                            <label for="loginemail" class="separator">Email:
                            <input class="separator" name="loginemail" id="loginemail" type="email" placeholder="Log in with your Email" 
                                   size="60" maxlength="100" autocomplete="off"/></label>
                            <label for="loginpass" class="separator">Password:
                            <input class="separator" name="loginpass" id="loginpass" type="password" placeholder="Enter your Password" 
                                   size="60" maxlength="100" autocomplete="off"
                                   title="Must contain at least 1 uppercase, 1 lowercase and 1 number/special character."></label>
                            <section class="separator">
                                <!--<article class="g-recaptcha" data-sitekey="6Ld16RYTAAAAAHYoqPeGafdXADe1ya7vEuXj871m">
                                </article>-->
                            </section>
                            <button class="loginbutton" name="loginbutton">LOGIN</button>
                            <p class="separatorlink">——————— Already have an account? Sign In! ———————</p>
                        </form>
                    </article>
                </section>


                <!-- Register Body -->
                <section id="register" class="tab-pane fade">
                    <article class="regibody">
                        <h1 class="maintitle">REGISTER</h1>
                        <form name="registerform" action="<?php echo htmlspecialchars("processregister.php");?>" method="post">
                            <label for="reginame" class="separator">Name:
                            <input class="separator" name="reginame" id="reginame" type="text" 
                                   placeholder="How do you want us to address you?" size="60" maxlength="100" autocomplete="off"
                                    /></label>
                            <label for="regiemail" class="separator">Email:
                            <input class="separator" name="regiemail" id="regiemail" type="email" 
                                   placeholder="At least 8 alphanumeric characters." size="60" maxlength="100" autocomplete="off"
                                    /></label>
                            <label for="regipass" class="separator">Password:
                            <input class="separator" name="regipass" id="regipass" type="password" 
                                   placeholder="Keep your password confidential!" size="60" maxlength="100" autocomplete="off"
                                   title="Must contain at least 1 uppercase, 1 lowercase and 1 number/special character."
                                   /></label>
                            <label for="regiconpass" class="separator">Confirm Password:
                            <input class="separator" name="regiconpass" id="regiconpass" type="password" 
                                   placeholder="Key in your password again." size="60" maxlength="100" autocomplete="off"
                                   title="Must contain at least 1 uppercase, 1 lowercase and 1 number/special character." 
                                   /></label> 
                            <section class="separator">
                                <!--<article class="g-recaptcha" data-sitekey="6Ld16RYTAAAAAHYoqPeGafdXADe1ya7vEuXj871m">
                                </article>-->
                            </section>
                            <button class="regibutton" name="regibutton">REGISTER</button>
                            <p class="separatorlink">—————————— New to Delta? Join us! ——————————</p>
                        </form>
                    </article>
                </section>

                <!-- Reset Pass Body -->
                <section id="resetpass" class="tab-pane fade">
                    <article class="resetbody">
                        <h1 class="maintitle">RESET PASSWORD</h1>
                        <form name="resetform" action="<?php echo htmlspecialchars("processreset.php");?>" method="post">
                            <label for="resetname" class="separator">Full Name:
                            <input class="separator" name="resetname" id="resetname" type="text" 
                                   placeholder="Enter Full Name" size="60" maxlength="70" autocomplete="off"/></label>
                            <label for="resetemail" class="separator">Email:
                            <input class="separator" name="resetemail" id="resetemail" type="email" 
                                   placeholder="Enter your Email Address" size="60" maxlength="100" autocomplete="off"/></label>
                            <section class="separator">
                                <!--<article class="g-recaptcha" data-sitekey="6Ld16RYTAAAAAHYoqPeGafdXADe1ya7vEuXj871m">
                                </article>-->
                            </section>
                            <button class="resetbutton" name="resetbutton">RESET PASSWORD</button>
                        </form>
                    </article>
                </section>
            </article>
        </section>

        <!-- FOOTER -->
        <?php
        include 'footer.php';
        ?>
        <script src="js/validregister.js"></script>
        <script src="js/validlogin.js"></script>
    </main>
</html>