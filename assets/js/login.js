$("#eye").on('click', function(evt){
  if (document.getElementById('pswdBox').type == "password" ){
    document.getElementById('pswdBox').type = 'text';
    $("#eye").find('i').toggleClass('fa-eye fa-eye-slash');
  }else{
     document.getElementById('pswdBox').type = 'password';
     $("#eye").find('i').toggleClass('fa-eye fa-eye-slash');
   }
});
