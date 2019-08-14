	function check(tekst)
{
	
	var reg = /^[a-zA-Z]{1}[a-zA-Z0-9\._\-&]{0,63}(\+{1}[a-zA-Z0-9\._\-&]*)?@{1}[a-zA-Z0-9\._\-&]*\.{1}[a-zA-Z0-9\._\-&]*$/;
	
	alert(reg.test(tekst));
}
