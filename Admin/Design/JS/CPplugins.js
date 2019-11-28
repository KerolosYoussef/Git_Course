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
    // Categorie Details Show/Hide
    $(".cat h3").click(function(){
        $(this).next(".show-hide").slideToggle("slow");
    });
    $(".view span").click(function(){
        $(this).addClass("active").siblings("span").removeClass("active");
        if($(this).data('view')=="full"){
            $(".cat .show-hide").fadeIn("slow");
        } else {
            $(".cat .show-hide").fadeOut("slow");

        }
    });
    // Latest Items Pretty touch
    $(".toggle-info").click(function(){
        $(this).toggleClass('Selected').parent().next(".panel-body").slideToggle();
        if($(this).hasClass('Selected')){
            $(this).html("<i class='dropdown-items fa fa-plus fa-lg'></i>")
        } else {
            $(this).html("<i class='dropdown-items fa fa-minus fa-lg'></i>")
        }
    })
})

// Function To Order The Categorie

var button = document.getElementById("send");
function getData(){
    var data = document.getElementById("sortselect");
    return data.value;
}
function getOrder(){
    var data2= document.getElementById("orderselect");
    return data2.value;
}
button.onclick = function(){
    window.location = "categories.php?sortBy="+getData()+"&sort="+ getOrder();
}


