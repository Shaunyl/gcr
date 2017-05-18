$('.to_register, .to_login').click(function (e) {
    e.preventDefault();
    $('.loginform, .regform').slideToggle(0);
});

$(document).ready(function () {
    $('#confirmemail,#confirmpassword').keyup(function () {
        var tmp = null;
        
        var curval = $(this).attr('id');

        if (curval == 'confirmemail') {
            tmp = $('#email').val();
        } else if (curval == 'confirmpassword') {
            tmp = $('#regpassword').val();
        }   

        if (tmp) {
            var cnick = $(this).val();
            if (cnick.length == 0) {
                $(this).css("color", "#555");
                return;
            }
            
            if (tmp == cnick) {
                $(this).css("color", "green");
                $('#email').keyup();
            } else {
                $(this).css("color", "red");
            }
        }
    });

    $('#email').keyup(function () {

        var text = $(this).val();
        if (text.length == 0) {
            $(this).css("color", "#555");
            return;
        }
        
        var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (pattern.test(text)) {
            $(this).css("color", "green");
            $('#confirmemail').keyup();
        } else {
            $(this).css("color", "red");
        }
    });

    $('#regpassword').keyup(function () {
        $('#confirmpassword').keyup();
    });

    // $('#useremail').change(function(e){
       // // Your event handler
       // // checkInputLogin();
    // });
// 
    // // And now fire change event when the DOM is ready
    // $('#logpassword,#useremail').trigger('change');
});




