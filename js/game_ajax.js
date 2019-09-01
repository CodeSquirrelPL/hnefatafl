var zbite = new Array(2);	//licznik zbitych pionków - zbite[0]: czarne; zbite[1]: białe


var url = ['<img src="img/king.svg" class="gamepiece_img"/>', '<img src="img/white.svg"  class="gamepiece_img"/>', '<img src="img/black.svg" class="gamepiece_img"/>']
//var move = 0; //zaczynają czarne (jeśli chcesz zmienić, zmodyfikuj funkcję "whoseCounter()")

//var players = ["czarne", "białe"];
var xml = new XMLHttpRequest();
//var players_id - 0 - czarne, 1 białe
// color - zdefiniowane w game.php (wartości 1 lub 0)

/**************************** klasa Field *******************************/

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

/**************************** ustalenie położenia figur *********************************/

var board = new Array(11);

/**************************** rysowanie planszy *****************************************/



/**************************** rozstawianie figur *****************************************/

function rozstaw_figury()
{

	if (color==move%2) {txt= " - twój ruch";}
	else {txt = " - odśwież stronę (F5), żeby sprawdzić, czy wykonał_a już ruch";}
	$('#current_player').html(players[move%2]+txt);
	$('#surrender__button').attr("onclick", 'surrender()');

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

/**************************** sprawdzanie figur i pól ***********************************/


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


function switch_players()	{
	move++;
	var txt="kuku na muniu";
	if (color==move%2) {txt= " - twój ruch";}
	else {txt = " - odśwież stronę (F5), żeby sprawdzić, czy wykonał_a już ruch";}
	$('#current_player').html(players[move%2]+txt);
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

	xml.open('GET', "game_send_move.php?a="+(y1*11+x1)+"&b="+(y*11+x)+"&counter="+board[x1][y1].value+"&setting="+setting+"&game="+game, false);
	xml.send(null);


	board[x][y].set(board[x1][y1].value);
	board[x1][y1].set(0);
	board[x1][y1].notAble();
	x1=0;
	y1=0;

	if_striking(x, y);

	if (board[x][y].value==1) end(x, y);
	else switch_players();

}

/**************************** bicie ***********************************/

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

function shieldwall(x, y, d)	{

	if (d==1)
	{

		//czy pionek jest o jeden rząd od krawędzi i czy między nim a krawędzią jest wrogi pionek
		if (	(x!=1 && x!=9 && y!=1 && y!=9) ||
					(x==1 && y==1 && board[0][y].isThisMine()!=0 && board[x][0].isThisMine()!=0) ||
					(x==9 && y==1 && board[10][y].isThisMine()!=0 && board[x][0].isThisMine()!=0) ||
					(x==9 && y==9 && board[10][y].isThisMine()!=0 && board[x][10].isThisMine()!=0) ||
					(x==1 && y==9 && board[0][y].isThisMine()!=0 && board[x][10].isThisMine()!=0) ||
					(x==1 && board[0][y].isThisMine()!=0) ||
					(x==9 && board[10][y].isThisMine()!=0) ||
					(y==1 && board[x][0].isThisMine()!=0) ||
					(y==9 && board[x][10].isThisMine()!=0)	)	{
			console.log("sprzeczne dane d>0");
			return 0;
		}

		else console.log("wstępna walidacja d>0 ok");

		//czy pionek jest pierwszym z zewnątrz
		if (	(x%8==1 || y%8==1) &&
					(x==1 && (y>1 && board[0][y-1].isThisMine()==1) ^ (y<10 && board[0][y+1].isThisMine()==1)) ||
					(x==9 && (y>1 && board[10][y-1].isThisMine()==1) ^ (y<10 && board[10][y+1].isThisMine()==1)) ||
					(y==1 && (x>1 && board[x-1][0].isThisMine()==1) ^ (y<10 && board[x+1][0].isThisMine()==1)) ||
					(y==9 && (x>1 && board[x-1][10].isThisMine()==1) ^ (y<10 && board[x+1][10].isThisMine()==1))	)
		{
			console.log("pierwszy");


			if ((x==1 && (y>9 || board[0][y+1].isThisMine()!=1) && (y<1 || board[0][y-1].isThisMine()!=1)) ||
					(x==9 && (y>9 || board[10][y+1].isThisMine()!=1) && (y<1 || board[10][y-1].isThisMine()!=1)) ||
					(y==1 && (x>9 || board[x+1][0].isThisMine()!=1) && (x<1 || board[x-1][0].isThisMine()!=1)) ||
					(y==9 && (x>9 || board[x+1][10].isThisMine()!=1) && (x<1 || board[x-1][10].isThisMine()!=1))		)	{
				console.log("sprzeczne argumenty");
				return 0;
				}
				else console.log("prawidłowe argumenty");
								//sprawdzone: czy pionek znajduje się w przedostatniej linii, czy między pionkiem a krawędzią jest wrogi pionek, czy w sąsiedztwie ukośnym przy krawędzi znajduje się przyjazny pionek.

			i=0;
			j=0;

			//czy między
			if (x==1)	{
				if (y<10 && board[0][y+1].isThisMine()==0) j=1;
				else if (y>0 && board[0][y-1].isThisMine()==0) j=-1;
				else console.log("warunek 1");
				i=0;
			}
			else if (x==9)	{
				if (y<10 && board[10][y+1].isThisMine()==0) j=1;
				else if (y>0 && board[10][y-1].isThisMine()==0) j=-1;
				else console.log("warunek 2");
				i=0;
			}
			else if (y==1) {
				if (x<10 && board[x+1][0].isThisMine()==0) i=1;
				else if (x>0 && board[x-1][0].isThisMine()==0) i=-1;
				else console.log("warunek 3");
				j=0;
			}
			else if (y==9) {
				if (x<10 && board[x+1][10].isThisMine()==0) i=1;
				else if (x>0 && board[x-1][10].isThisMine()==0) i=-1;
				else console.log("warunek 4");
				j=0;
			}
			else return "zxc";

			if (i==0 && j==0) return "xyz";


			//i oraz j przechowują odległość i kierunek pola badanego od pola, na którym stoi figura, której przesunięcie uruchomiło funkcję

			if (j==0) {if (y==1) d=-1; if (y==9) d=1;}
			else if (i==0) {if (x==1) d=-1; if (x==9) d=1;}

			do {
				if (i!=0 && j!=0) return "asd";

				if (j==0)	{	//	j==0 -> przesunięcie odbywa się wzdłuż osi x -> sprawdzaj [x+i][y+d]
					if (board[x+i][y+d].isThisMine()!=0) return "qwe";
					if (i<0) i--; if (i>0) i++;	}

				if (i==0)	{
					if (board[x+d][y+j].isThisMine()!=0) return "rty";
					if (j>0) j++; if (j<0) j--;	}

			} while (board[x+i][y+j].isThisMine()==1);

			// pionek przy krawędzi planszy jako punkt odniesienia (do zmiany)
			if (i==0) console.log("x+d="+(x+d)+", y+j="+(y+j)+"; board[x+d][y+j].isThisMine()="+board[x+d][y+j].isThisMine());
			if (j==0) console.log("x+i="+(x+i)+", y+d="+(y+d)+"; board[x+i][y+d].isThisMine()=="+board[x+i][y+d].isThisMine());
							//usuwanie pionków z planszy
			if (board[x+i][y+j].isThisMine()!=1 && (
				(i==0 && board[x+d][y+j].isThisMine()==1) || (j==0 && board[x+i][y+d].isThisMine()==1)
			))	{
				console.log("usuwanie pionków; i="+i+", j="+j+", d="+d+", x="+x+", y="+y);
				do {
					if (j<0) j++; if (j>0) j--;
					if (i<0) i++; if (i>0) i--;
					if ((x%8)==1) striking(x+d, y+j);
					else if ((y%8)==1) striking(x+i, y+d);
				} while (i || j);
				console.log("usuwanie pionków zakończone; i="+i+", j="+j+", d="+d);
			}
			else {console.log("uio"); return "uio";}
		}
		else {
			console.log("nie pierwszy");
			if ((x%8==1 && 0<y<10 && board[x][y+1].isThisMine()==1 && board[x][y-1].isThisMine()==1) ||
					(y%8==1 && 0<x<10 && board[x+1][y].isThisMine()==1 && board[x-1][y].isThisMine()==1))	{
				console.log("może być w środku");
				if (y%8==1 && board[x+1][y].isThisMine()==1 && board[x-1][y].isThisMine()==1)	{
					if (y==1) d=-1;
					else if (y==9) d=1;
					i=0;
					do {
						i++;
						console.log("x+i: "+(x+i));
					} while ((x+i)<10 && board[x+i][y+d].isThisMine()==0);
					if (board[x+i][y+d].isThisMine()==1)	{
						console.log("x+i: "+(x+i));
						console.log("ostatni pionek: "+(x+i-1)+", "+y);
						shieldwall(x+i-1, y, 1);
					}
					else {
						console.log("nie ma");
						return 0;
					}
				}

				if (x%8==1 && board[x][y+1].isThisMine()==1 && board[x][y-1].isThisMine()==1)	{
					if (x==1) d=-1;
					else if (x==9) d=1;
					i=0;
					do {
						i++;
					} while (y+i<10 && board[x+d][y+i].isThisMine()==0);
					if (board[x+d][y+i].isThisMine()==1)	{
						console.log("y+i: "+(y+i));
						console.log("ostatni pionek: "+x+", "+(y+i-1));
						shieldwall(x, y+i-1, 1);
					}
					else {
						console.log("nie ma");
						return 0;
					}
				}
			}
		}
	}
	else if (d==0)
	{
		console.log("pionek przy krawędzi");
		if (x==0) {
			console.log("x="+x+", y="+y+" board[1][y+1].isThisMine()=="+board[1][y+1].isThisMine());
			if (y<10 && board[1][y+1].isThisMine()==1) {console.log("1a; 1, "+(y+1)+", 1"); shieldwall(1, y+1, 1);}
			if (y>0 && board[1][y-1].isThisMine()==1) {console.log("1b; 1, "+(y-1)+", 1"); shieldwall(1, y-1, 1);}
		}
		else if (x==10)	{
			if (y<10 && board[9][y+1].isThisMine()==1) {console.log("2a; 9, "+(y+1)+", 1"); shieldwall(9, y+1, 1);}
			if (y>0 && board[9][y-1].isThisMine()==1) {console.log("2b; 9, "+(y-1)+", 1"); shieldwall(9, y-1, 1);}
		}
		if (y==0) {
			if (x<10 && board[x+1][1].isThisMine()==1) {console.log("3a; "+(x+1)+", 1, 1"); shieldwall(x+1, 1, 1);}
			if (x>0 && board[x-1][1].isThisMine()==1) {console.log("3b; "+(x-1)+", 1, 1"); shieldwall(x-1, 1, 1);}
		}
		else if (y==10)	{
			if (x<10 && board[x+1][9].isThisMine()==1) {console.log("4a; "+(x+1)+", 9, 1"); shieldwall(x+1, 9, 1);}
			if (x>0 && board[x-1][9].isThisMine()==1) {console.log("4b; "+(x-1)+", 1, 1"); shieldwall(x-1, 9, 1);}
		}
		else return 0;
	}
	else console.log("nieprawidłowy argument d");

}

/**************************** kończenie gry ***********************************/

function game_over(winner_color, message) {

	xml.open('GET', 'game_end.php?game='+game+'&winner='+players_id[winner_color]+'&setting='+setting, true);
	xml.send(null);
	for (x=0; x<11; x++)
	{
		for (y=0; y<11; y++)
		{
			board[x][y].notAble();
			$('#'+x+"x"+y).attr("onmouseover", "");
		}
	}

	$('#current_player').html(message+players[winner_color]);
	alert ('game over');

}

function end(x, y)	//przyjmuje położenie króla; zwraca 0, jeśli gra nie jest zakończona
{
	if (board[x][y].value!=1)	//jeśli przyjęte parametry nie są adresem króla
	{
		if (zbite[0]>23) var winner = 1;
		else {if (zbite[1]>11) var winner = 0;
						else {switch_players(); return 0;}
					}
	}
	else if ((board[x-oneoneone(x)][y].value)%2+(board[x+oneone(x)][y].value)%2+(board[x][y-oneoneone(y)].value)%2+(board[x][y+oneone(y)].value)%2 == 4)
	{	var winner = 0;	}	//0 - czarne
	else if (x%10==0 && y%10==0)
	{	var winner = 1;	}	//1 - białe
	else {	switch_players(); return 0;	}

	game_over(winner, "Gra zakończona. Zwyciężył(a): ");
}


function surrender()	{
	if (!confirm("czy na pewno chcesz poddać grę?")) return 0;

	game_over((color+1)%2, "Poddałaś_eś się. Zwyciężył(a) ");
}
