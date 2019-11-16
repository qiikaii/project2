<html>

<head>
    <title>DELTA - CHECK OUT</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Top 1 self-designed fashion in Singapore">
    <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!--<script src="js/main.js"></script>-->
    <script src="js/checkout.js"></script>
    <link rel="stylesheet" href="css/checkout.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">

</head>

<h1></h1>
<?php
include "header.inc.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<body>
    <section class="checkoutpage">
        <h1>Shipping Details</h1>
        <form name="myForm" action="process_checkout.php" onsubmit="return validateForm()" method="post">
            <div class="firstsection">
                <p class="accountpagecaption">Kindly Check Your Credential Before Checking Out...</p>

                <article class="secondsection">
                    <section class="accountinfo-form">
                        <label class="inputtitle">PHONE :</label>
                        <input type="tel" class="accountinfo-form-style" id="handphone" name="handphone" placeholder="Enter Handphone Number " pattern="(8|9)[0-9]{7}" maxlength="8" required>
                        <label class="inputtitle">POSTAL CODE :</label>
                        <input type="tel" class="accountinfo-form-style" id="postal" name="postal" placeholder="Enter Your Postal Code" required>
                        <label class="inputtitle">ADDRESS :</label>
                        <input type="text" class="accountinfo-form-style" id="address" name="address" placeholder="Enter Your Address">
                    </section>




                    <label class="inputtitle">CARD NUMBER :</label>
                    <input type="tel" class="addCardForm" id="card" name="card" value="" pattern="^(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}$" placeholder="Enter Your Card No Without Space." maxlength="16" required>
                    <!--pattern for credit card -'^[0-9]{4}[-]+[0-9]{4}[-]+[0-9]{4}[-]+[0-9]{4}$'-->
                    <label for="exp-month" class="inputtitle">EXPIRY DATE</label>
                    <section class="ccForm-row">

                        <select class="addCardForm ccForm" id="expday" name="expday" required>
                            <option value="1">JANUARY</option>
                            <option value="2">FEBRUARY</option>
                            <option value="3">MARCH</option>
                            <option value="4">APRIL</option>
                            <option value="5">MAY</option>
                            <option value="6">JUNE</option>
                            <option value="7">JULY</option>
                            <option value="8">AUGUST</option>
                            <option value="9">SEPTEMBER</option>
                            <option value="10">OCTOBER</option>
                            <option value="11">NOVEMBER</option>
                            <option value="12">DECEMBER</option>
                        </select>

                        <select class="addCardForm ccForm" id="expmonth" name="expmonth" required>
                            <option value="19">2019</option>
                            <option value="20">2020</option>
                            <option value="21">2021</option>
                            <option value="22">2022</option>
                            <option value="23">2023</option>
                            <option value="24">2024</option>
                            <option value="25">2025</option>
                            <option value="26">2026</option>
                            <option value="27">2027</option>
                            <option value="28">2028</option>
                            <option value="29">2029</option>
                        </select>

                    </section>

                    <label class="inputtitle">CVV :</label>
                    <input type="tel" class="addCardForm" id="cvv" name="cvv" value="" maxlength="3" placeholder="Enter Your Credit Card CVV" required>

                    <label class="inputtitle">NAME ON CARD :</label>
                    <input type="text" class="addCardForm" id="namecard" name="namecard" value="" maxlength="40" placeholder="Enter Your Credit Card Name" onkeyup="myFunction1()" required>
                </article>
            </div>
            <article class="modal-footer">
                <button type="submit" name="checkout" class="btn1 btn-submit" onclick="checkout()">CHECKOUT</button>
            </article>
        </form>
    </section>
</body>
<?php
include "footer.inc.php";
?>

</html>