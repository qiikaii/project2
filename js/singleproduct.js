/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validateInput(event) {
    var size = document.forms["cart-form"]["size"].value;
    var qty = document.forms["cart-form"]["quantity"].value;

    if (qty >= 10 || qty <= 1) {
        alert("Please choose a valid quantity.");
        event.preventDefault();
        return false;
    }

    if (size != 'S' || $size != 'M' || $size != 'L') {
        alert("Please choose a valid size.");
        event.preventDefault();
        return false;
    }
}