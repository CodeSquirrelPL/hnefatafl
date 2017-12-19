// komunikaty: obiekt
// login -  4 opcje: poprawny, za krótki lub za długi, niedozwolone znaki, zajęte
// hasło - 6 opcji: poprawne, brak małej litery. brak wielkiej litery, brak cyfry, niedozwolone znaki, za krótklie lub za długie
// hasła - 2 opcje: takie same lub różne
// email - 4 opcje: brak, poprawne, niepoprawne, występuje w bazie

//w zewnętrznym pliku: jedynie zmienne (treść komunikatów). Sama klasa we wnętrzu pliku, tutaj funkcja wywołująca konstruktor - plik js z ajaksem i innymi gównami do  rejestracji, podobnie jak pliki php, będzie taki sam dla wszystkich języków.

function alerts(log, pass, pass2, em)
{

//każdy z argumentów jest tablicą

  this.login = log;
  this.pass = pass;
  this.pass2 = pass2;
  this.email = em;
}

function setAlerts()
{
 return new alerts(log, pass, pass2, em);
}

/*
var sru = "srutututu";

function alerts()
{
  this.login = "log";
  this.pass = "pass";
  this.pass2 = "pass2";
  this.email = "em";
}*/
