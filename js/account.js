var result = "";
var oldPassword;
var newPassword;
var newEmail;
var xml = new XMLHttpRequest();

function zxc()  //onload
{
  $("#reject").attr("onclick", "rejectChallenge()");
}

function rejectChallenge()  {
  alert("zxc");
  xml.open('GET', 'game_end.php?game='+game+'&winner='+winner+'&setting='+setting, true);
	xml.send(null);
  return 0;
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

function check_password(pass1)
{
	if (pass1.length<6 || pass1.length>64)
  {

		newPassword.feedback("hasło musi się składać z min 6, max 64 znaków");
    return 0;
  }

	var reg = /[a-z]/;
	if (!reg.test(pass1))
  {
    newPassword.feedback("hasło musi zawierać min. 1 małą literę");
    return 0;
  }

	reg = /[A-Z]/;
	if (!reg.test(pass1))
  {
    newPassword.feedback("hasło musi zawierać min. 1 dużą literę");
    return 0;
  }

	reg = /[0-9]/;
	if (!reg.test(pass1))
  {
    newPassword.feedback("hasło musi zawierać min. 1 cyfrę");
    return 0;
  }

	reg = /^[a-zA-Z0-9;:<=>\?@]*$/
	if (!reg.test(pass1))
  {
    newPassword.feedback("hasło zawiera niedozwolone znaki");
    return 0;
  }

	else {newPassword.feedback(""); return 1;}
}

function validateEmailForm(form)
{
  if (form.pass.value=="" || form.email.value=="") { alert("wypełnij wszystkie pola!"); return 0; }
  newEmail = new data("nowy adres e-mail", form.email.value, $("#passMsg"));
  if (verify_passwd(form.pass.value)==0 || emailValidate(newEmail.value)==0) {alert("formularz nie został wypełniony poprawnie"); return 0;}
  else alert("formularz został poprawnie wypełniony"); $("#email_form").submit();
}

function validatePasswdForm(form)
{
  if (form.old.value=="" || form.pass1.value=="" || form.pass2.value=="") { alert("wypełnij wszystkie pola!"); return 0; }
  newPassword = new data("nowe hasło", form.pass1.value, $("#pass1Msg"));
  if (form.pass1.value!=form.pass2.value) { newPassword.feedback("podane hasła są różne"); return 0;  }
  if (verify_passwd(form.old.value)==0 || changePasswd(oldPassword.value, newPassword.value)==0) {alert("formularz nie został wypełniony poprawnie"); return 0;}
  else alert("formularz został poprawnie wypełniony"); $("#passwd_form").submit();

}

function verify_passwd(oldPass)
{
    oldPassword = new data("dotychczasowe hasło", oldPass, $("#oldPassMsg"));
    $.post(
    'php/account/verifyPass.php',
    {pass: oldPass},
    function(data)
    {result=data; if (data==1) {$("#oldPassMsg").html('podano prawidłowe hasło'); return 1;} else {oldPassword.feedback("nieprawidłowe hasło"); return 0;}}
  )
}

function changePasswd(oldPass, newPass)
{
    if (newPass==oldPass) {newPassword.feedback("nowe hasło nie różni się od poprzedniego"); return 0;}
    return check_password(newPassword.value);
}

function emailValidate(email)
{
  if (email) return 1;
  else return 0;
}
