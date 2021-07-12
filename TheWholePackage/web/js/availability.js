$(document).ready(function(){
    $("#username").keyup(function(){
        var username = $(this).val().trim();
        if(username !== ''){
            $.ajax({
                type: 'post',
                data: {extra: 1, username:username},
                success: function(response){
                    $("#availability").html(response);
                }
            });
        }else{
            $("#availability").html("");
        }
    });
});
$(document).ready(function(){
    $("#email").keyup(function(){
        var email = $(this).val().trim();
        if(email !== ''){
            $.ajax({
                type: 'post',
                data: {extra: 1, email:email},
                success: function(response){
                    $("#availability").html(response);
                }
            });
        }else{
            $("#availability").html("");
        }
    });
});
$(function() {
    $('#username').on('keypress', function(e) {
        if (e.which === 32){
            return false;
        }
    });
});
$(function() {
    $('#email').on('keypress', function(e) {
        if (e.which === 32){
            return false;
        }
    });
});