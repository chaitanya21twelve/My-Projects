jQuery(document).ready(function(){

 
});
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
        };
    function isValidName(nameField){
        var validName=new RegExp(/^[a-zA-Z ]*$/);
        return validName.test(nameField);
    }

    /*---------------------------RYB Login Start--------------------------*/   

    var rybWineSelect={
        'wineID'        : '',
        'wineYear'      : '',
        'wineBottle'    : '',
        'wineName'      : '',
        'wineStock'     : ''
    };
    var rybWineStoryMid={
        'wineOpened'          : '',
        'wineOccasion'        : '',
        'wineReview'          : '',
        'wineOccasionCity'    : '',
        'wineRating'          : ''
    };

    var rybWineStoryLast={
        'wineEnjoyedWith'     : '',
        'wineStory'           : '',
        'wineFlavor'        : '',
    };

    var rybGallery={
        'filedata' : []
    };
	var filecounter=0;
	var placecounter=0;
	var j=0;
	var igallery={};

	var rybFinalSubmit={
		'wineSelected'  : '',
		'wineStory'     : '',
		'wineStoryMore' : '',
		'wineGallery'   : ''
	};

    jQuery(document).on("click","#ryb_login_btn",function(e){
        e.preventDefault();        
        var i="yes";    
        var userEmail = jQuery( '#ryb_login_email' ).val();
        var password  = jQuery( '#ryb_login_upass' ).val();
        var security  = jQuery( '#security' ).val();
        var urltoLoad       = window.location.href;
        jQuery(".form-loader").show();      

        var baseUrl = document.location.origin; 
        var final_string="action=userLogin&userEmail="+userEmail+"&password="+password+"&security="+security;
        var ajaxurl =baseUrl+'/wp-admin/admin-ajax.php';
        jQuery.ajax({
        type:    "POST",
        url:     ajaxurl,
        data:    final_string,
        async : true,
        success: function(lkus){ 
        var msg=parseInt(lkus);
        if(msg=="3"){
        jQuery(".form-loader").hide();
        jQuery("#login_error").show();
        jQuery("#login_error").html("Invalid Login");             
        }         
        else {   
        window.location=urltoLoad+"?ryb=true";
        }
        }
        });
    });    
     /*---------------------------RYB Login End--------------------------*/      
    /*---------------------------RYB Registration Start--------------------------*/ 
    jQuery(document).on("click","#ryb_btn", function(e){
        e.preventDefault();
        var i="yes";
        var fname         = jQuery("#ryb_fname").val();
        var lname         = jQuery("#ryb_lname").val();
        var ryb_email     = jQuery("#ryb_email").val();
        var ryb_phone     = jQuery("#phone").val();
        var ryb_password  = jQuery("#ryb_password").val();
        var ryb_cpassword = jQuery("#ryb_cpassword").val();
        var urltoLoad       = window.location.href;
        var lastNameVali = /^[a-zA-Z\-\']+$/;
 

        if(fname==""){jQuery("#regis_error").show(); jQuery("#regis_error").addClass("error");jQuery("#regis_error").html("<span>Please enter your first name.</span>");i="no";}
        else if (!isValidName(fname)){jQuery("#regis_error").show(); jQuery("#regis_error").addClass("error");jQuery("#regis_error").html("<span>Only letters and white space allowed on first name.</span>");i="no";}
        else if(lname==""){jQuery("#regis_error").show(); jQuery("#regis_error").addClass("error");jQuery("#regis_error").html("<span>Please enter your last name.</span>");i="no";}
        else if (!lastNameVali.test(lname)){jQuery("#regis_error").show(); jQuery("#regis_error").addClass("error");jQuery("#regis_error").html("<span>Only letters and white space allowed on last name.</span>");i="no";}
        else if(!isValidEmailAddress(ryb_email)){jQuery("#regis_error").show(); jQuery("#regis_error").addClass("error");jQuery("#regis_error").html("<span>Please enter a valid email address.</span>");i="no";}
        else if (ryb_phone!="" && !jQuery("#phone").intlTelInput("isValidNumber")) {jQuery("#regis_error").show(); jQuery("#regis_error").html("<span>Please enter a valid phone number.</span>");i="no";}
        else if(ryb_password=="" || ryb_password.length<=7){jQuery("#regis_error").show(); jQuery("#regis_error").addClass("error");jQuery("#regis_error").html("<span>Password should be 8 chars long.</span>");i="no";}
        else if( ryb_cpassword != ryb_password ) {jQuery("#regis_error").show(); jQuery("#regis_error").addClass("error");jQuery("#regis_error").html("<span>Please enter the correct confirm password.</span>");i="no"; }
        if(i=="yes"){
            jQuery("#regis_error").hide(); 
            jQuery(".form-loader").show();
            var baseUrl = document.location.origin; 
            var final_string="action=userSignup&fname="+fname+"&lname="+lname+"&ryb_email="+ryb_email+"&ryb_phone="+ryb_phone+"&ryb_password="+ryb_password;
            var ajaxurl =baseUrl+'/wp-admin/admin-ajax.php';
            jQuery.ajax({
            type:    "POST",
            url:     ajaxurl,
            data:    final_string,
            async : true,
            success: function(lkus){ 
            var msg=parseInt(lkus);
            
            if(msg=="3"){      
            jQuery(".form-loader").hide();  
            jQuery("#regis_error").show();    
            jQuery(".ryb_user_reg_error").html("Email already registered, Please login to continue.");             
            } 
            else if (msg=="4"){
                jQuery("#regis_error").show();   
                jQuery(".form-loader").hide();
                jQuery(".ryb_user_reg_error").html("Something went wrong, Please reload the page."); 
            }        
            else if (msg=="2"){   
            window.location=urltoLoad+"?ryb=true";
            }
            }
            });

        }// if all inputs are validated
        
    }); 

 
    /*8--------------------------------Code by Vijendra for Login/Registraion on wineclueb Start------------------*/
    jQuery(document).on("click","#ryb_login_btn_wc",function(e){
    e.preventDefault();        
    var i="yes";    
    var userEmail = jQuery( '#ryb_login_email_wc' ).val();
    var password  = jQuery( '#ryb_login_upass_wc' ).val();
    //var security  = jQuery( '#security_wc' ).val();
    var urltoLoad       = window.location.href;
    jQuery(".form-loader").show();      
    var baseUrl = document.location.origin; 
    var final_string="action=userLogin&userEmail="+userEmail+"&password="+password;
    var ajaxurl =baseUrl+'/wp-admin/admin-ajax.php';
    jQuery.ajax({
    type:    "POST",
    url:     ajaxurl,
    data:    final_string,
    async : true,
    success: function(lkus){ 
    var msg=parseInt(lkus);
    if(msg=="3"){
    jQuery(".form-loader").hide();
    jQuery("#login_error_wc").show();
    jQuery("#login_error_wc").html("Invalid Login");     

    }         
    else {   
    window.location=urltoLoad+"?wc=true";
    }
    }
    });
});    

 /*---------------------------RYB Login End--------------------------*/      
/*---------------------------RYB Registration Start--------------------------*/ 
jQuery(document).on("click","#ryb_btn_wc", function(e){
    e.preventDefault();
    var i="yes";

    var fname         = jQuery("#ryb_fname_wc").val();
    var lname         = jQuery("#ryb_lname_wc").val();
    var ryb_email     = jQuery("#ryb_email_wc").val();
    var ryb_phone     = jQuery("#phone_wc").val();
    var ryb_password  = jQuery("#ryb_password_wc").val();
    var ryb_cpassword = jQuery("#ryb_cpassword_wc").val();
    var urltoLoad       = window.location.href.split('#')[0];
    var lastNameVali = /^[a-zA-Z\-\']+$/;


    if(fname==""){jQuery("#regis_error_wc").show(); jQuery("#regis_error_wc").addClass("error");jQuery("#regis_error_wc").html("<span>Please enter your first name.</span>");i="no";}
    else if (!isValidName(fname)){jQuery("#regis_error_wc").show(); jQuery("#regis_error_wc").addClass("error");jQuery("#regis_error_wc").html("<span>Only letters and white space allowed on first name.</span>");i="no";}
    else if(lname==""){jQuery("#regis_error_wc").show(); jQuery("#regis_error_wc").addClass("error");jQuery("#regis_error_wc").html("<span>Please enter your last name.</span>");i="no";}
    else if(!lastNameVali.test(lname)){jQuery("#regis_error_wc").show(); jQuery("#regis_error_wc").addClass("error");jQuery("#regis_error_wc").html("<span>Only letters and white space allowed on last name.</span>");i="no";}
    else if(!isValidEmailAddress(ryb_email)){jQuery("#regis_error_wc").show(); jQuery("#regis_error_wc").addClass("error");jQuery("#regis_error_wc").html("<span>Please enter a valid email address.</span>");i="no";}
    else if (ryb_phone!="" && !jQuery("#phone_wc").intlTelInput("isValidNumber")) {jQuery("#regis_error_wc").show(); jQuery("#regis_error_wc").html("<span>Please enter a valid phone number.</span>");i="no";}
    else if(ryb_password=="" || ryb_password.length<=7){jQuery("#regis_error_wc").show(); jQuery("#regis_error_wc").addClass("error");jQuery("#regis_error_wc").html("<span>Password should be 8 chars long.</span>");i="no";}
    else if( ryb_cpassword != ryb_password ) {jQuery("#regis_error_wc").show(); jQuery("#regis_error_wc").addClass("error");jQuery("#regis_error_wc").html("<span>Please enter the correct confirm password.</span>");i="no"; }
    if(i=="yes"){
        jQuery("#regis_error_wc").hide(); 
        jQuery(".form-loader").show();
        var baseUrl = document.location.origin; 
        var final_string="action=userSignup&fname="+fname+"&lname="+lname+"&ryb_email="+ryb_email+"&ryb_phone="+ryb_phone+"&ryb_password="+ryb_password;
        var ajaxurl =baseUrl+'/wp-admin/admin-ajax.php';
        jQuery.ajax({
        type:    "POST",
        url:     ajaxurl,
        data:    final_string,
        async : true,
        success: function(lkus){ 
        var msg=parseInt(lkus);
        
        if(msg=="3"){      
        jQuery(".form-loader").hide();  
        jQuery("#regis_error_wc").show();    
        jQuery(".ryb_user_reg_error").html("Email already registered, Please login to continue.");             
        } 
        else if (msg=="4"){
            jQuery("#regis_error_wc").show();   
            jQuery(".form-loader").hide();
            jQuery(".ryb_user_reg_error").html("Something went wrong, Please reload the page."); 
        }        
        else if (msg=="2"){   
        window.location=urltoLoad+"?wc=true";
        }
        }
        });
    }// if all inputs are validated
}) ; 

/*8--------------------------------Code by Vijendra for Login/Registraion on wineclueb end------------------*/


var iCnt = 1;
jQuery(document).ready(function(){

jQuery('.steps_form_action a').on('click',function (){
varAttr = jQuery(this).attr('data-step-action');
jQuery('.step_hide').removeClass('active');
jQuery('#data_step_'+ varAttr).addClass('active');                
});

jQuery(".phone").intlTelInput({
utilsScript: "https://intl-tel-input.com/node_modules/intl-tel-input/build/js/utils.js"
});

jQuery("#form_tab li a, .register_ac a").click(function (evt) {
evt.preventDefault();
getId = jQuery(this).attr('href');
jQuery('#form_tab li a').removeClass('active');
jQuery(this).addClass('active');
jQuery('.form_tab_content').removeClass('active');
jQuery(getId).addClass('active');
jQuery(getId + '_action').addClass('active');
});

jQuery(".register_ac_wc a").click(function (evt) {
evt.preventDefault();
var getId = jQuery(this).attr('href');
var tabClass=jQuery(this).attr('class');

if(tabClass=="show_reg_form_tab"){
jQuery('#form_tab_wc li a').removeClass('active');
jQuery('.form_tab_content').removeClass('active');
 jQuery('#form_tab_wc li a#register_form_action_vr').addClass('active');
 jQuery("#register_form_wc").addClass('active');
}
else if(tabClass=="show_log_form_tab"){
jQuery('#form_tab_wc li a').removeClass('active');
jQuery('.form_tab_content').removeClass('active');
 jQuery('#form_tab_wc li a#login_form_action_vr').addClass('active');
 jQuery("#login_form_wc").addClass('active');
}
});

jQuery(document).on("click",".close_modal_vr",function(){
    
   jQuery('#form_tab_wc li a').removeClass('active');
   jQuery('#login_form_action_vr').addClass('active');

   jQuery('#form_tab li a').removeClass('active');
   jQuery('#login_form_action').addClass('active');

   jQuery('.form_tab_content').removeClass('active');
   jQuery('#login_form_wc').addClass('active');
   jQuery('#login_form').addClass('active');

});

jQuery(document).ready(function () {
var owl = jQuery('.product_slider_block');
owl.owlCarousel({
nav: true,
items: 1,
loop: true,
margin: 10,
autoplay: true,
autoplayTimeout: 3000,
autoplayHoverPause: true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:2,
            nav:true
        },
        1000:{
            items:1,
            nav:true
        }
    }
});
});

});

jQuery("#addFriend").click(function(){
if (iCnt <= 4) {
jQuery("#enjoyedwith").append("<div class='added_field vc_col-sm-6 vc_col-xs-12'><input type='text' class='form-control friends_name' name='friends_name[]' id='addFriend_"+iCnt+"' placeholder='First Name ( First Letter of Last Name only)' /><i id='removefriend_"+iCnt+"' class='fa fa-times remove_friend' aria-hidden='true'></i></div>");
iCnt = iCnt + 1;
}// maximum friends

});
jQuery(document).on("click",".remove_friend",function(){
var myid=jQuery(this).attr('id');
var myidarr=myid.split("_");

var friendtoRemove="#addFriend_"+myidarr['1'];
var parentDiv    = jQuery(friendtoRemove).parents(".added_field").remove();
//jQuery(friendtoRemove ).remove();
jQuery(this).hide();

});

