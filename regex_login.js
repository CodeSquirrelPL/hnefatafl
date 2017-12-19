	function check(login)
{
//zwraca 0 - login poprawny
//zwraca 1 - login jest za krótki lub za długi
//zwraca 2 - login zawiera niedozwolone znaki
	
	if (login.length<4 || login.length>64) alert("1");
	else
	var reg = /^[a-zA-Z0-9\.\-_]{4,64}$/;
	
	if (reg.test(login)) alert("0");
	else alert("2");
}
