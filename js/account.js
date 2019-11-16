/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    $('.zoom').magnify();
});

$('#paymentModalPopup').modal({
        backdrop: true
    });
    
$(function () {
    $(".btnclose").on('click', function() {
        $('#paymentModalPopup').modal('hide');
    });
});

window.onload = function(){
var accountinfo = document.getElementById('accountinfo');
var orders = document.getElementById('orders');
var payment = document.getElementById('payment');
var background = document.getElementById('default');
var tablinks = document.getElementsByClassName('tablinks');
var tabitems = document.getElementsByClassName("tabitems");
var accountinfo1 = document.getElementById('accountinfo1');
var orders1 = document.getElementById('orders1');
var payment1 = document.getElementById('payment1');
for (var i = 0; i < tabitems.length; i++) {
    tabitems[i].style.display = 'none';
}
 for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

accountinfo.addEventListener('click', accounttab);
orders.addEventListener('click', orderstab);
payment.addEventListener('click', paymenttab);


function accounttab(){  
    background.style.display = "none";
    accountinfo1.style.display = "block";
    orders1.style.display = "none";
    payment1.style.display = "none";
    tablinks[0].className += ' active';
    tablinks[1].className = tablinks[1].className.replace(" active", "");
    tablinks[2].className = tablinks[2].className.replace(" active", "");
}

function orderstab(){
    background.style.display = "none";
    accountinfo1.style.display = "none";
    orders1.style.display = "block";
    payment1.style.display = "none";
    tablinks[1].className += ' active';
    tablinks[0].className = tablinks[1].className.replace(" active", "");
    tablinks[2].className = tablinks[2].className.replace(" active", "");
}

function paymenttab(){
    background.style.display = "none";
    accountinfo1.style.display = "none";
    orders1.style.display = "none";
    payment1.style.display = "block";
    tablinks[2].className += ' active';
    tablinks[1].className = tablinks[1].className.replace(" active", "");
    tablinks[0].className = tablinks[2].className.replace(" active", "");
}

/* Start of Validation */
document.getElementById('email').addEventListener('input', validateEmail)

$('#email').change(function(){
    $('#email').validateEmail();
});    
    
function validateEmail(){
    var emailInput = document.getElementById('email');
    var r = new RegExp(/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/);
    if (r.test(emailInput.value) == false){
        emailInput.setCustomValidity('JS: Please enter a valid email address');
    }
    else if (r.test(emailInput.value) == true){
        return true;
    }
}

document.getElementById('firstname').addEventListener('input', validateName)

function validateName(){
    var name = document.getElementById('firstname').value;
    var r=/[A-Za-z]{3,50}/;
    if (r.test(name.value) == false){
        name.setCustomValidity('JS: Name can only contain letter, at least 3 characters long and not mroe than 50 characters');
    }
    else if (r.test(name.value) == true){
        return true;
    }
}

document.getElementById('pw').addEventListener('input', validatePw)

function validatePw(){
    var pw = document.getElementById('pw');
    var r=/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,15}$/;
    if (r.test(pw.value) == false){
        pw.setCustomValidity('JS: 1 uppercase, 1 lowercase, 1 number, 1 special character');
    }
    else if (r.test(pw.value) == true){
        return true;
    }
}


document.getElementById('card').addEventListener('input', validateCard)

function validateCard(){
    var card = document.getElementById('card').value;
    var r=/^\d{16}$/;
    if (r.test(card) == false){
        card.setCustomValidity('JS: Please enter a valid 16 digit card numbers');
    }
    else if (r.test(card) == true){
        return true;
    }
}

}

