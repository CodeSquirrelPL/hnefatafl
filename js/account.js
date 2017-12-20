var result = "";
var password;
function zxc()
{
    button = $("#emailButton");
    button.attr('onclick', 'validatePasswdForm(passwd_form)');
    var box = $("#oldPassMsg");
    password = new data("hasło", "aaAA11", box);
}

function data(label, content, box) {

  this.label = label;
  this.content = content;
  this.box = box;

  this.feedback = function(content) {
    this.box.html(content);
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
    {result=data; if (data==1) {$("#oldPassMsg").html('podano prawidłowe hasło'); if (newPass) changePasswd(oldPass, newPass);} else password.feedback("nieprawidłowe hasło");}
  )
}

function changePasswd(oldPass, newPass)
{
    if (newPass==oldPass) password.feedback("nowe hasło nie różni się od poprzedniego");
    check_password(newPass);
}
