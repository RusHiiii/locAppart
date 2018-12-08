$("#eye").on('click', function(){
  if ($("#user_password_first").attr('type') == "password" ){
    $("#user_password_first").attr('type', 'text');
    $("#eye").find('i').toggleClass('fa-eye fa-eye-slash');
  }else{
     $("#user_password_first").attr('type', 'password');
     $("#eye").find('i').toggleClass('fa-eye fa-eye-slash');
   }
});

$("#eyeBox2").on('click', function(){
  if ($("#user_password_second").attr('type') == "password" ){
    $("#user_password_second").attr('type', 'text');
    $("#eyeBox2").find('i').toggleClass('fa-eye fa-eye-slash');
  }else{
     $("#user_password_second").attr('type', 'password');
     $("#eyeBox2").find('i').toggleClass('fa-eye fa-eye-slash');
   }
});

$("#user_password_second").on('keyup', function(evt){
  if($("#user_password_second").val() == $("#user_password_first").val()){
      $("#user_password_second").css('border-color', "#66cc66");
      $("#user_password_first").css('border-color', "#66cc66");
  }else{
      $("#user_password_second").css('border-color', "#ff6666");
      $("#user_password_first").css('border-color', "#ff6666");
  }
});
