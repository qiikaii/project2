/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* Start of Update Password Validation */
document.getElementById('pwd').addEventListener('input', validateOldPw);
document.getElementById('newpwd').addEventListener('input', validateNewPw);
document.getElementById('cfmnewpwd').addEventListener('input', validateCfmNewPw);

function validateOldPw(event){
    var pwd = document.getElementById('pwd');
    var r = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}/;
    pwd.setCustomValidity('');
    if (pwd.value === ""){
        pwd.setCustomValidity("Old Password can't be blank");
        pwd.reportValidity();
        event.preventDefault();
    }
    
    else if (r.test(pwd.value) === false){
        pwd.setCustomValidity('Must contain at least 8 characters with 1 uppercase, 1 lowercase and 1 number/special character.');
        pwd.reportValidity();
        event.preventDefault();   
        return false;
    }
    else if (r.test(pwd.value) === true){
        return true;
    }
}

function validateNewPw(event){
    var newpwd = document.getElementById('newpwd');
    var r = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}/;
    newpwd.setCustomValidity('');
    if (newpwd.value === ""){
        newpwd.setCustomValidity("New Password can't be blank");
        newpwd.reportValidity();
        event.preventDefault();
    }
    
    else if (r.test(newpwd.value) === false){
        newpwd.setCustomValidity('Must contain at least 8 characters with 1 uppercase, 1 lowercase and 1 number/special character.');
        newpwd.reportValidity();
        event.preventDefault();   
        return false;
    }
    else if (r.test(newpwd.value) === true){
        return true;
    }
}

function validateCfmNewPw(event){
    var cfmnewpwd = document.getElementById('cfmnewpwd');
    var newpwd = document.getElementById('newpwd');
    var r = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}/;
    cfmnewpwd.setCustomValidity('');
    if (cfmnewpwd.value === ""){
        cfmnewpwd.setCustomValidity("Confirm New Password can't be blank");
        cfmnewpwd.reportValidity();
        event.preventDefault();
    }
    
    else if (r.test(cfmnewpwd.value) === false){
        cfmnewpwd.setCustomValidity('Must contain at least 8 characters with 1 uppercase, 1 lowercase and 1 number/special character.');
        cfmnewpwd.reportValidity();
        event.preventDefault();   
        return false;
    }
    
    else if (cfmnewpwd.value !== newpwd.value){
        cfmnewpwd.setCustomValidity('Password doesnt match');
        cfmnewpwd.reportValidity();
        event.preventDefault();   
        return false;
    }
    else if (r.test(cfmnewpwd.value) === true){
        return true;
    }
    
}

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


}

