var zbite = new Array(2);	//licznik zbitych pionków - zbite[0]: czarne; zbite[1]: białe
var i, j, x, y;
var style_throne = "background-image: url(img/throne.png); background-size: 100% 100%";
var style_x = "background-image: url(img/x.png); background-size: 100% 100%";
var url = ['<img src="img/king.svg" class="gamepiece_img"/>', '<img src="img/white.svg"  class="gamepiece_img"/>', '<img src="img/black.svg" class="gamepiece_img"/>']
//var move = 0; //zaczynają czarne (jeśli chcesz zmienić, zmodyfikuj funkcję "whoseCounter()")
var x1=0, y1=0;
//var players = ["czarne", "białe"];
var xml = new XMLHttpRequest();

/**************************** klasa Field *******************************/

function Field(x, y, counter)
{
	this.id = x+"x"+y;
	this.x = x;
	this.y = y;
	this.value = counter;
}

Field.prototype.ableCounter = function()
{
	$('#'+this.id).attr("class", "square able");
	$('#'+this.id).attr("onclick", "board["+this.x+"]["+this.y+"].chosing()");
};

Field.prototype.ableField = function()
{
	$('#'+this.id).attr("class", "square able");
	$('#'+this.id).attr("onclick", "moving("+this.x+", "+this.y+")");
};

Field.prototype.notAble = function()
{
	$('#'+this.id).attr("class", "square");
	$('#'+this.id).attr("onclick", "");
};

Field.prototype.abilityCounter = function()
{
	if (this.whoseCounter()==color+1 && color==move%2 && oneoneone(board[this.x-oneoneone(this.x)][this.y].value)+oneoneone(board[this.x+oneone(this.x)][this.y].value)+oneoneone(board[this.x][this.y-oneoneone(this.y)].value)+oneoneone(board[this.x][this.y+oneone(this.y)].value)+this.ifThrone() < 4)
	{
		this.ableCounter();
	}
	else
	{
		this.notAble();
	}
};

Field.prototype.chosing = function()
{
	x1 = this.x;
	y1 = this.y;
	$('#'+this.id).attr("class", "square chosen");
	$('#'+this.id).attr("onclick", "moving("+this.x+", "+this.y+")");
};

Field.prototype.set = function(counter)
{
	this.value = counter;
	if (this.value!=0)
	$('#'+this.id).html(url[counter-1]);
	else $('#'+this.id).html("");
};

Field.prototype.whoseCounter = function() //0 - puste pole, 1 - czarne (zaczynają), 2 - białe
{
	if (this.value==0) return 0;
	if (this.value==3) return 1;
	else return 2;
};

Field.prototype.ifThrone = function()
{
	if (this.value==1) return 0;
	if (this.x%10==0 && this.y%8==1) return 1;
	else if (this.x%8==1 && this.y%10==0) return 1;
	else if ((((this.x==4 || this.x==6) && this.y==5) || ((this.y==4 || this.y==6) && this.x==5)) && board[5][5].value==0) return 1;
	else return 0;
};

/**************************** ustalenie położenia figur *********************************/

var board = new Array(11);

/**************************** rysowanie planszy *****************************************/

function rysuj_plansze()
{
	if (color==move%2) {txt= " - twój ruch";}
	else {txt = " - odśwież stronę (F5), żeby sprawdzić, czy wykonał_a już ruch";}
	$('#current_player').html(players[move%2]+txt);

	$('#side_1').html("");
	$('#side_0').html("");
	var plansza = "";

	for (i=0; i<11; i++)
	{
		for (j=0; j<11; j++)
		{
			plansza = plansza + '<div class="square" id="' + j + 'x' + i + '"';
			if ((i%10==0 && j%10==0) || (i==5 && j==5))
				plansza = plansza + ' style="'+style_throne+'"';
			else if ((i>2 && i<8 && j%10==0) || (j>2 && j<8 && i%10==0) || (i%8==1 && j==5) || (i==5 && j%8==1) || (i%4==3 && j==5) || (i==4 && j>3 && j<7) || (i==5 && j>2 && j<8) || (i==6 && j>3 && j<7))
				plansza = plansza + ' style="'+style_x+'"';
			plansza = plansza + ' onmouseover="ability('+j+', '+i+')"></div>';
		}


	}

	plansza += "<p><a href='yielding.php?game=" + game + "'><button>poddaj się</button></a></p>";

	$('#'+"board").html(plansza);


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
	$('#'+"side_0").html(side);

	var side="";
	for (i=zbite[1]; i>0; i--)
	{
		side += url[1];
	}
	$('#'+"side_1").html(side);
}

/**************************** funkcje ***********************************/

function oneoneone(x)
{
	if (x==0) return 0;
	else return 1;
}

function oneone(x)
{
	if (x==10) return 0;
	else return 1;
}

/**************************** sprawdzanie figur i pól ***********************************/

function ability(x, y)
{
	if (x1==0 && y1==0) board[x][y].abilityCounter();
	else ability_fields(x, y);
}

function ability_fields(x, y) //sprawdzanie, czy na polu można postawić aktywnego pionka
{
	if (x==x1 && y==y1)
		{
			return 0;
		}

	if (board[x1][y1].value!=1 && ((x%10==0 && y%10==0) || (x==5 && y==5))) //jeśli pionek nie jest królem, a miejsce jest tronem
		{
			board[x][y].notAble();
			return 0;
		}

	if (x1==x)	//jeśli pole jest w tej samej płaszczyźnie x co pole startowe
	{
		/* nieprzeskakiwanie nad tronem
		if (x==5 && board[x1][y1].value!=1 && Math.max(y1, y)>5 && Math.min(y1, y)<5)
		{
			board[x][y].notAble();
			return 0;
		}	*/

		if (y>y1)
			for (i=y-y1; i>0; i--)
		{
			if (board[x][y1+i].value)
			{
				board[x][y].notAble();
				return 0;
			}
		}
		else if (y1>y)
			for (i=y1-y; i>0; i--)
		{
			if (board[x][y1-i].value)
				{
					board[x][y].notAble();
					return 0;
				}
		}
	}
	else if (y1==y)	//jeśli pole jest w tej samej płaszczyźnie y co pole startowe
	{
		/* nieprzeskakiwanie nad tronem
		if (y==5 && board[x1][y1].value!=1 && Math.max(x1, x)>5 && Math.min(x1, x)<5)
			{
				board[x][y].notAble();
				return 0;
			}	*/

		if (x>x1)
		for (i=x-x1; i>0; i--)
		{
			if (board[x1+i][y].value)
			{
				board[x][y].notAble();
				return 0;
			}
		}
		if (x1>x)
		for (i=x1-x; i>0; i--)
		{
			if (board[x1-i][y].value)
			{
				board[x][y].notAble();
				return 0;
			}
		}
	}
	else {board[x][y].notAble(); return 0;}

	board[x][y].ableField();
}

/**************************** ruch ***********************************/

function moving(x, y)
{
	if (x1==0 && y1==0) return 0;

	if (x1==x && y1==y)
	{
		board[x][y].ableCounter();
		x1=0;
		y1=0;
		return 0;
	}

	xml.open('GET', "php/ajax/game_send_move.php?a="+(y1*11+x1)+"&b="+(y*11+x)+"&counter="+board[x1][y1].value+"&setting="+setting+"&game="+game, false);
	xml.send(null);


	board[x][y].set(board[x1][y1].value);
	board[x1][y1].set(0);
	board[x1][y1].notAble();
	x1=0;
	y1=0;
	if (board[x][y].value==1) end(x, y);
	if_striking(x, y);
	move++;
	var txt="kuku na muniu";
	if (color==move%2) {txt= " - twój ruch";}
	else {txt = " - odśwież stronę (F5), żeby sprawdzić, czy wykonał_a już ruch";}
	$('#'+"current_player").html(players[move%2]+txt);


}

/**************************** bicie ***********************************/

function if_striking(x, y)
{
	if (x>1 && board[x-1][y].whoseCounter()==(move+1)%2+1 && (board[x-2][y].whoseCounter()==move%2+1 || (x==2 && y%10==0) || (x==7 && y==5 && board[5][5].value==0))) striking((x-1), y);
		if (x>0 && board[x-1][y].value==1) end(x-1, y);
	if (x<9 && board[x+1][y].whoseCounter()==(move+1)%2+1 && (board[x+2][y].whoseCounter()==move%2+1 || (x==8 && y%10==0) || (x==3 && y==5 && board[5][5].value==0))) striking((x+1), y);
		if (x<10 && board[x+1][y].value==1) end(x+1, y);
	if (y>1 && board[x][y-1].whoseCounter()==(move+1)%2+1 && (board[x][y-2].whoseCounter()==move%2+1 || (y==2 && x%10==0) || (y==7 && x==5 && board[5][5].value==0))) striking(x, (y-1));
		if (y>0 && board[x][y-1].value==1) end(x, y-1);
	if (y<9 && board[x][y+1].whoseCounter()==(move+1)%2+1 && (board[x][y+2].whoseCounter()==move%2+1 || (y==8 && x%10==0) || (y==3 && x==5 && board[5][5].value==0))) striking(x, (y+1));
		if (y<10 && board[x][y+1].value==1) end(x, y+1);
}

function striking(x, y)
{
		if (board[x][y].value==1) {end(x,y); return 0};
		zbite[(move+1)%2]++;
		var side="";
		for (i=zbite[(move+1)%2]; i>0; i--)
		{
			side += url[move%2+1];
		}
		$('#'+"side_"+(move+1)%2).html(side);
		xml.open('GET', "game_send_striking.php?where="+(y*11+x)+"&counter="+board[x][y].value+"&setting="+setting, false);
		xml.send(null);
		board[x][y].set(0);
		end(x,y);
}

/**************************** kończenie gry ***********************************/

function end(x, y)	//przyjmuje położenie króla; zwraca 0, jeśli gra nie jest zakończona
{
	if (board[x][y].value!=1)	//jeśli przyjęte parametry nie są adresem króla
	{
		if (zbite[0]>23) var winner = id_white;
		else {if (zbite[1]>11) var winner = id_black;
		else return 0;}
	}
	else if ((board[x-oneoneone(x)][y].value)%2+(board[x+oneone(x)][y].value)%2+(board[x][y-oneoneone(y)].value)%2+(board[x][y+oneone(y)].value)%2 == 4)
	{	var winner = id_black;	}
	else if (x%10==0 && y%10==0)
	{	var winner = id_white;	}
	else {	return 0;	}

	xml.open('GET', 'game_end.php?game='+game+'&winner='+winner+'&setting='+setting, true);
	xml.send(null);
	for (x=0; x<11; x++)
	{
		for (y=0; y<11; y++)
		{
			board[x][y].notAble();
			$('#'+x+"x"+y).attr("onmouseover", "");
		}
	}

	$('#current_player').html("Gra zakończona. Zwyciężył(a) "+players[winner]);
	alert ('game over');

}
