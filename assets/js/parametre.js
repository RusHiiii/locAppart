/*************** LISTENER ***************/

/** Listener sur l'oeil */
$("#eye").on('click', function(){
  console.log($("[id$='password_first']"));
  if ($("[id$='password_first']").attr('type') == "password" ){
    $("[id$='password_first']").attr('type', 'text');
    $("#eye").find('i').toggleClass('fa-eye fa-eye-slash');
  }else{
     $("[id$='password_first']").attr('type', 'password');
     $("#eye").find('i').toggleClass('fa-eye fa-eye-slash');
   }
});

/** Listener sur l'oeil */
$("#eyeBox2").on('click', function(){
  if ($("[id$='password_second']").attr('type') == "password" ){
    $("[id$='password_second']").attr('type', 'text');
    $("#eyeBox2").find('i').toggleClass('fa-eye fa-eye-slash');
  }else{
     $("[id$='password_second']").attr('type', 'password');
     $("#eyeBox2").find('i').toggleClass('fa-eye fa-eye-slash');
   }
});

/** Listener sur la validité du mot de passe */
$("[id$='password_second']").on('keyup', function(evt){
  if($("[id$='password_second']").val() == $("[id$='password_first']").val()){
      $("[id$='password_second']").css('border-color', "#66cc66");
      $("[id$='password_first']").css('border-color', "#66cc66");
  }else{
      $("[id$='password_second']").css('border-color', "#ff6666");
      $("[id$='password_first']").css('border-color', "#ff6666");
  }
});

/** Listener sur le form de MàJ */
$('form[name="user"]').on('submit', function(evt){
  $('#user_save').empty();
  $('#user_save').addClass('loading spinner');
});

/** Listener sur le form de MDP */
$('form[name="user_edit"]').on('submit', function(evt){
    $('#user_edit_save').empty();
    $('#user_edit_save').addClass('loading spinner');
});