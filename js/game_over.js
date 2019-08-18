var zbite = new Array(2);
var i, j, x, y;
var style_throne = "background-image: url(img/throne.png)";
var style_x = "background-image: url(img/x.png)";
var url = ['<img src="img/king.svg" class="gamepiece_img"/>', '<img src="img/white.svg"  class="gamepiece_img"/>', '<img src="img/black.svg" class="gamepiece_img"/>'];
var xml = new XMLHttpRequest();

/**************************** klasa Field *******************************/

function Field(x, y, counter)
{
	this.id = x+"x"+y;
	this.x = x;
	this.y = y;
	this.value = counter;
}

Field.prototype.set = function(counter)
{
	this.value = counter;
	if (this.value!=0)
	document.getElementById(this.id).innerHTML = url[counter-1];
	else document.getElementById(this.id).innerHTML ="";
};
/**************************** ustalenie położenia figur *********************************/

var board = new Array(11);

/**************************** rysowanie planszy *****************************************/

function rysuj_plansze()
{
	$("#current_player").html("koniec gry");

	$('#surrender').css("display", "none");

	document.getElementById("side_1").innerHTML = "";
	document.getElementById("side_0").innerHTML = "";
	var plansza = "";

	for (i=0; i<11; i++)
	{
		for (j=0; j<11; j++)
		{
			plansza = plansza + '<div class="board__cell" id="' + j + 'x' + i + '"';
			if ((i%10==0 && j%10==0) || (i==5 && j==5))
				plansza = plansza + ' style="'+style_throne+'"';
			else if ((i>2 && i<8 && j%10==0) || (j>2 && j<8 && i%10==0) || (i%8==1 && j==5) || (i==5 && j%8==1) || (i%4==3 && j==5) || (i==4 && j>3 && j<7) || (i==5 && j>2 && j<8) || (i==6 && j>3 && j<7))
				plansza = plansza + ' style="'+style_x+'"';
			plansza = plansza + '></div>';
		}


	}


	document.getElementById("board").innerHTML = plansza;

	rozstaw_figury();
}

/**************************** rozstawianie figur *****************************************/

function rozstaw_figury()
{
//legenda: 0 = pole jest puste; 1 = na polu stoi król; 2 = na polu stoi obrońca króla; 3 = na polu stoi buntownik;
	zbite = [0, 0];

	for (i=0; i<11; i++)
	{
		board[i] = new Array(11);

		for (j=0; j<11; j++)
		{
			board[i][j] = new Field(i, j, 0);
		}
	}

	x = white[0][0];
	y = white[0][1];
	board[x][y].set(1);

	for (i=1; i<13; i++)
	{
		if (white[i][0]+white[i][1])
		{
			x = white[i][0];
			y = white[i][1];
			board[x][y].set(2);
		}
		else zbite[1]++;
	}

	for (i=0; i<24; i++)
	{
		if (black[i][0]+black[i][1])
		{
			x = black[i][0];
			y = black[i][1];
			board[x][y].set(3);
		}
		else zbite[0]++;
	}

	var side="";
	for (i=zbite[0]; i>0; i--)
	{
		side += url[2];
	}
	document.getElementById("side_0").innerHTML = side;

	var side="";
	for (i=zbite[1]; i>0; i--)
	{
		side += url[1];
	}
	document.getElementById("side_1").innerHTML = side;

	//alert("Koniec gry!");
	xml.open('GET', 'close_game.php?game='+game, true);
	xml.send(null);
}
