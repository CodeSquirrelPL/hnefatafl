if (typeof XMLHttpRequest == "undefined") {
    XMLHttpRequest = function() {
        return new ActiveXObject(
            navigator.userAgent.indexOf("MSIE 5") >=0 ? "Microsoft.XMLHTTP" : "Msxml2.XMLHTTP"
        );
    }
}

var bool = 0;

var xml = new XMLHttpRequest();

function clearInput(id)
{
  document.getElementById(id).innerHTML = "";
}

function check_login(login)
{
	if (login.length<4 || login.length>64)
  {
    document.getElementById("login_msg").innerHTML = 'login musi składać się z min 4, max 64 znaków';
    return 0;
  }

	var reg = /^[a-zA-Z0-9_]*$/;

	if (reg.test(login)==0)
  {
    document.getElementById("login_msg").innerHTML = 'login zawiera niedozwolone znaki';
    return 0;
  }

  check_database(login, 'login');
  if (bool) return 1;
  else return 0;
}

function check(form)
{
  var login = [check_login(form.login.value), check_password(form.pass.value), check_passwords(form.pass.value, form.pass2.value), check_email(form.email.value)];
	if (login[0]!=0 && login[1]!=0 && login[2]!=0 && login[3]!=0)
  {
    document.getElementById("rejestracja").submit();
  }
	return 0;
}
