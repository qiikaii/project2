
function validateForm() {
    var x = document.forms["myForm"]["card"].value;
    var y = document.forms["myForm"]["namecard"].value;
    var ycard = /^[a-zA-Z]{3,45}$/.test(y)
    var aaa = /^(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}$/.test(x)
    var bbb = /^4[0-9]{12}(?:[0-9]{3})?$/.test(x)
    var ccc = /^3[47][0-9]{13}$/.test(x)
    var ddd = /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/.test(x)
    var eee = /^6(?:011|5[0-9]{2})[0-9]{12}$/.test(x)
    var fff = /^6(?:011|5[0-9]{2})[0-9]{12}$/.test(x)
    var ggg = /^(?:2131|1800|35\d{3})\d{11}$/.test(x)
    if (x == null || x == "") {
        alert("Please Enter Your Credit Card number!");
        return false; 
    }
    else if (y == null || y == "") {
        alert("Card Name Must Be Filled Up!");
        return false;
    }
    else if (x.length<4){
        alert("Please Re-enter Card Number");
        return false;
    }
    else if (ycard == false){
        alert("Not enough letters");
        return false;
    }
    else if (aaa == false && bbb == false && ccc == false && ddd == false 
            && eee == false && fff == false && ggg == false){
        alert("Credit Card Error");
        return false;
    }
    else {
        alert("Payment Succeed");
    }

}