/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validateInput(event) {
    var size = document.forms["cart-form"]["size"].value;
    var qty = document.forms["cart-form"]["quantity"].value;

    if (qty >= 1 && qty <= 10) {

    } else {
        alert("Please choose a valid quantity.");
        event.preventDefault();
        return false;
    }

    if (size == "S" || size == "M" || size == "L") {
    }
    else {
        alert("Please choose a valid size.");
        event.preventDefault();
        return false;
    }
}