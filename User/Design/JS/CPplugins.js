$(function(){
    // Start Selectbox Plugins
    $("select").selectBoxIt({
        autowidth:false
    });
    // Make Placeholder Disappear while focus and appear while blur
    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
        $(this).removeAttr('data-text');
    })
    // Add Asterisk on Required Fieald 
    $('input').each(function(){
        if($(this).attr('required')==='required'){
            $(this).after('<span class="asterisk">*</span>');
        }
    });
    // Show Password eye 
    $('.show-pass').click(function(){
        if($('.password').attr('type')=='password'){
            $('.password').attr('type','text');
        }
        else {
            $('.password').attr('type','password');
        }
    })
    // Delete Button [Manage Page]
    $(".confirm").click(function(){
        return confirm("Are You Sure You want to Delete This?");
    })
    
    // Latest Items Pretty touch
    $(".toggle-info").click(function(){
        $(this).toggleClass('Selected').parent().next(".panel-body").slideToggle();
        if($(this).hasClass('Selected')){
            $(this).html("<i class='dropdown-items fa fa-plus fa-lg'></i>")
        } else {
            $(this).html("<i class='dropdown-items fa fa-minus fa-lg'></i>")
        }
    })
    // Check if the password is the same or not
    var check;
    $(".checkpassword").blur(function(){
        if($(".sign-form .checkpassword").val()==$('.sign-form .password').val()){
            $('.error').fadeOut("slow");
            check = 1;
        } else {
            $('.error').fadeIn("slow");
            check = 0;
        }
    })
    $('.sign-form').submit(function(e){
        if(check == 0){
            e.preventDefault();
        }
    })
    // Switch Between Login / Sign up
    $('.login-signup h1 span').click(function(){
        if($(this).data('class') == 'login-form'){
            $(this).addClass('x-active').siblings().removeClass('y-active');
        } else {
            $(this).addClass('y-active').siblings().removeClass('x-active');
        }
            $(".login-signup form").hide();
            $("."+$(this).data('class')).fadeIn("slow");
        })
})


