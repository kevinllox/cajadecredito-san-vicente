/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('#add_exercise').on('click', function() { 
    $('#exercises').append('<div class="exercise"><input type="text" name="exercise[]"><button class="remove">x</button></div>');
    return false; //prevent form submission
});

$('#exercises').on('click', '.remove', function() {
    $(this).parent().remove();
    return false; //prevent form submission
});