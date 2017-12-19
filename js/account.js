var result = "";

function zxc()
{
    $("#emailButton").attr('onclick', 'validatePasswdForm(passwd_form)');
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
  if (form.old.value=="" || form.pass1.value=="" || form.pass1.value=="") { alert("wypełnij wszystkie pola!"); return 0; }
  if (form.pass1.value!=form.pass2.value) { alert("podane hasła są różne"); return 0;  }
  verify_passwd(form.old.value, form.pass1.value);
}

function verify_passwd(oldPass, newPass)
{
    $.post(
    'php/account/verifyPass.php',
    {pass: oldPass},
    function(data)
    {result=data; if (data==1) {$("#oldPassMsg").html('podano prawidłowe hasło'); if (newPass) check_password(newPass);} else $("#oldPassMsg").html("nieprawidłowe hasło");}
  )
}


/*********************************************************/

/*********************************************************/
