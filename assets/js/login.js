/*************** LISTENER ***************/

/** Listener du mot de passe */
$("#eye").on('click', function(evt){
  if ($("#pswdBox").attr('type') == "password" ){
    $("#pswdBox").attr('type', 'text');
    $("#eye").find('i').toggleClass('fa-eye fa-eye-slash');
  }else{
     $("#pswdBox").attr('type', 'password');
     $("#eye").find('i').toggleClass('fa-eye fa-eye-slash');
   }
});

/** Listener du form */
$('#login_form').on('submit', function(evt){
  $('.validate').empty();
  $('.validate').addClass('loading spinner');
});
