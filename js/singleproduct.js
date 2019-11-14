/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function increase(){
                var textBox = document.getElementById("quantity");
                if (textBox.value >= 20){
                textBox.value = 1;
            } else{                
                textBox.value++;
            }   
        }

function decrease(){
              var textBox = document.getElementById("quantity");
              if (textBox.value > 1){
                textBox.value--;
            } else{                
                textBox.value = 1;
            }
            }    
