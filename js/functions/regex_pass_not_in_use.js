	function check(tekst)
{
	
	var reg = /^[a-zA-Z0-9;:<=>\?@]*$/
	reg = /[a-z]/;
	reg = /[A-Z]/;
	reg = /[0-9]/;
	
	alert(reg.test(tekst));
}
