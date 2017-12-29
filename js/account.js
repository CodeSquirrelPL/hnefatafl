var result = "";
var oldPassword;
var newPassword;
function zxc()
{
    $("#emailButton").attr('onclick', 'validatePasswdForm(passwd_form)');
}

function data(label, value, box) {

  this.label = label;
  this.value = value;
  this.box = box;

  this.feedback = function(value) {
    this.box.html(value);
  }
}


function hide_form(id)
{
  $('#'+id+'_form').css('display', 'none');
  $('#'+id+'_show').text('zmień '+id);
  $('#'+id+'_show').attr('onclick', 'show_form("'+id+'")');
}

function show_form(id)
{
  $('#'+id+'_form').css('display', 'inline');
  $('#'+id+'_show').text('schowaj formularz');
  $('#'+id+'_show').attr('onclick', 'hide_form("'+id+'")');
}

function validatePasswdForm(form)
{
  oldPassword = new data("dotychczasowe hasło", form.old.value, $("#oldPassMsg"));
  newPassword = [new data("nowe hasło", form.pass1.value, $("#pass1Msg")), new data("powtórzone nowe hasło", form.pass2.value, $("#pass2Msg"))];
  if (oldPassword.value=="" || newPassword[0].value=="" || newPassword[1].value=="") { alert("wypełnij wszystkie pola!"); return 0; }
  if (form.pass1.value!=form.pass2.value) { password.feedback("podane hasła są różne"); return 0;  }
  verify_passwd(form.old.value, form.pass1.value);
}

function verify_passwd(oldPass, newPass)
{
    $.post(
    'php/account/verifyPass.php',
    {pass: oldPass},
    function(data)
    {result=data; if (data==1) {$("#oldPassMsg").html('podano prawidłowe hasło'); if (newPass) changePasswd(oldPass, newPass);} else oldPassword.feedback("nieprawidłowe hasło");}
  )
}

function changePasswd(oldPass, newPass)
{
    if (newPass==oldPass) newPassword[0].feedback("nowe hasło nie różni się od poprzedniego");
    check_password(newPassword[0]);
}
