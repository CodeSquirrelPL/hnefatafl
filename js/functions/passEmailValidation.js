var bool = 0;



function check_password(pass1)
{
//zwraca 0 - hasło poprawne
//zwraca 1 - hasło jest za krótkie
//zwraca 2 - hasło zawiera niedozwolone znaki
//zwraca 3 - hasło nie zawiera niezbędnych znaków

	if (pass1.length<6 || pass1.length>64)
  {

		$("#pass_msg").html("hasło musi się składać z min 6, max 64 znaków");
    return 0;
  }

	var reg = /[a-z]/;
	if (!reg.test(pass1))
  {
    $("#pass_msg").html("hasło musi zawierać min. 1 małą literę");
    return 0;
  }

	reg = /[A-Z]/;
	if (!reg.test(pass1))
  {
    $("#pass_msg").html("hasło musi zawierać min. 1 dużą literę");
    return 0;
  }

	reg = /[0-9]/;
	if (!reg.test(pass1))
  {
    $("#pass_msg").html("hasło musi zawierać min. 1 cyfrę");
    return 0;
  }

	reg = /^[a-zA-Z0-9;:<=>\?@]*$/
	if (!reg.test(pass1))
  {
    $("#pass_msg").html("hasło zawiera niedozwolone znaki");
    return 0;
  }

	else {$("#pass_msg").html(""); return 1;}
}

function check_passwords (pass1, pass2)
{
	if (pass1==pass2) {$("#pass2_msg").html(""); return 1;}
	else
  {
    $("#pass2_msg").html("hasła są różne");
    return 0;
  }
}

function check_email(adress)
{
	if (!adress || adress == "") return 1;

	var reg = /^[a-zA-Z]{1}[a-zA-Z0-9\._\-&]{0,63}(\+{1}[a-zA-Z0-9\._\-&]*)?@{1}[a-zA-Z0-9\._\-&]*\.{1}[a-zA-Z0-9\._\-&]*$/;

	if (!reg.test(adress))  {
  $("#email_msg").html("to nie jest adres e-mail. Masz pewność, że wpisane dane są poprawne? Zgłoś bug");
  return 0; }

  bool = 0;
  check_database(adress, 'email');
  if (bool)  return 1;
  else return 0;
}


function check_database(input, inputType) //step - krok pierwszy (login) lub drugi (mail)
{
	xml.open('GET', 'check_login.php?input='+input+'&inputType='+inputType, false);
  var response;
	xml.onreadystatechange = function()
	{
    		if ( xml.readyState == 4 )
    		{
      			response = xml.responseText;
            //document.getElementById("czekaj").innerHTML = response;
            if (response=="0")
            document.getElementById(inputType+"_msg").innerHTML = inputType+' jest zajęty';
            else if (response=="1") bool = 1; return 1;
    		} //else document.getElementById("submit").innerHTML = "czekaj, trwa łączenie"; //???
	};
	xml.send();
}
