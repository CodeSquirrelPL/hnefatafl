var zbite = [0, 0]; //które jest które? czarne 0, białe 1?
var i, j, x, y;
var style_throne = "background-image: url(img/throne.png); background-size: 100% 100%;";
var style_x = "background-image: url(img/x.png); background-size: 100% 100%;";
var url = ['<img src="img/king.svg" class="gamepiece_img" alt="król - biały, okrągły pionek z szarym krzyżykiem na środku"/>', '<img src="img/white.svg"  class="gamepiece_img" alt="biały, okrągły pionek"/>', '<img src="img/black.svg" class="gamepiece_img" alt="czarny, okrągły pionek"/>']	//0 - król, 1 - biały pionek, 2 - czarny pionek
var move = 0; //zaczynają czarne (jeśli chcesz zmienić, zmodyfikuj funkcję "whose_counter()")
var x1=0, y1=0;
var players = ["czarne", "białe"]; //0 czarne, 1 białe

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
	document.getElementById(this.id).setAttribute("class", "board__cell able");
	document.getElementById(this.id).setAttribute("onclick", "board["+this.x+"]["+this.y+"].chosing()");
};

Field.prototype.ableField = function()
{
	document.getElementById(this.id).setAttribute("class", "board__cell able");
	document.getElementById(this.id).setAttribute("onclick", "moving("+this.x+", "+this.y+")");
};

Field.prototype.notAble = function()
{
	document.getElementById(this.id).setAttribute("class", "board__cell");
	document.getElementById(this.id).setAttribute("onclick", "");
};

Field.prototype.abilityCounter = function()
{
	if (typeof aiColor!=='undefined' && aiColor!==null && move%2==aiColor) {this.notAble(); return 0;}

	if (this.isThisMine()==1 && oneoneone(board[this.x-oneoneone(this.x)][this.y].value)+oneoneone(board[this.x+oneone(this.x)][this.y].value)+oneoneone(board[this.x][this.y-oneoneone(this.y)].value)+oneoneone(board[this.x][this.y+oneone(this.y)].value)+this.ifThrone() < 4)
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
	document.getElementById(this.id).setAttribute("class", "board__cell chosen");
	document.getElementById(this.id).setAttribute("onclick", "moving("+this.x+", "+this.y+")");
};

Field.prototype.set = function(counter)
{
	this.value = counter;
	if (this.value!=0)
	document.getElementById(this.id).innerHTML = url[counter-1];
	else document.getElementById(this.id).innerHTML ="";
};
/*
Field.prototype.whoseCounter = function() //0 - puste pole, 1 - czarne (zaczynają), 2 - białe
{
	//pionek aktywnego gracza - move%2+1
	//pionek drugiego gracza - (move+1)%2+1
	if (this.value==0) return 0;
	if (this.value==3) return 1;
	else if (this.value==2 || this.value==1) return 2;
};*/

Field.prototype.isThisMine = function() //-1 - puste pole, 1 - aktywny gracz, 0 - drugi gracz
{
	if (this.value==0) return -1;
	if (this.value==3 && (move%2)==0) return 1;
	if (this.value==3 && (move%2)==1) return 0;
	if ((this.value==2 || this.value==1) && (move%2)==1) return 1;
	if ((this.value==2 || this.value==1) && (move%2)==0) return 0;
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

//tablica służy tylko do ustawienia figur na planszy, nie ma znaczenia w trakcie rozgrywki

var white = new Array(13);
white[0] = [5, 5];
white[1] = [3, 5];
white[2] = [4, 4];
white[3] = [4, 5];
white[4] = [4, 6];
white[5] = [5, 3];
white[6] = [5, 4];
white[7] = [5, 6];
white[8] = [5, 7];
white[9] = [6, 4];
white[10] = [6, 5];
white[11] = [6, 6];
white[12] = [7, 5];

var black = new Array(24);
black [0] = [0, 3];
black [1] = [0, 4];
black [2] = [0, 5];
black [3] = [0, 6];
black [4] = [0, 7];
black [5] = [1, 5];
black [6] = [3, 0];
black [7] = [4, 0];
black [8] = [5, 0];
black [9] = [5, 1];
black [10] = [6, 0];
black [11] = [7, 0];
black [12] = [3, 10];
black [13] = [4, 10];
black [14] = [5, 9];
black [15] = [5, 10];
black [16] = [6, 10];
black [17] = [7, 10];
black [18] = [9, 5];
black [19] = [10, 3];
black [20] = [10, 4];
black [21] = [10, 5];
black [22] = [10, 6];
black [23] = [10, 7];

var board = new Array(11);

/**************************** rysowanie planszy *****************************************/

function rysuj_plansze()
{
	document.getElementById("current_player").innerHTML = players[move%2] + " zaczynają";
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
			plansza = plansza + ' onmouseover="ability('+j+', '+i+')"></div>';
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
	move = 0;

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

	move=1;
	board[10][2].set(2);
	board[10][3].set(3);
	board[9][3].set(2);
	board[10][4].set(3);
	board[9][4].set(2);
	board[10][5].set(3);
	board[9][5].set(2);
	board[10][6].set(2);

	board[2][10].set(2);
	board[3][10].set(3);
	board[3][9].set(2);
	board[4][10].set(3);
	board[4][9].set(2);
	board[5][10].set(3);
	board[5][9].set(2);
	board[6][10].set(2);

	board[1][0].set(2);
	board[2][0].set(3);
	board[2][1].set(2);
	board[3][0].set(3);
	board[3][1].set(2);
	board[4][0].set(3);
	board[4][1].set(2);

	//board[5][1].set(2);
	board[5][0].set(2);

	board[6][0].set(3);
	board[6][1].set(2);
	board[7][0].set(3);
	board[7][1].set(2);
	board[8][0].set(3);
	board[8][1].set(2);
	//board[9][0].set(2);

	board[0][2].set(2);
	board[0][3].set(3);
	board[1][3].set(2);
	board[0][4].set(3);
	board[1][4].set(2);
	board[0][5].set(3);
	board[1][5].set(2);
	board[0][6].set(2);

/*
	for (i=1; i<13; i++)
	{
		x = white[i][0];
		y = white[i][1];
		board[x][y].set(2);
	}

	for (i=0; i<24; i++)
	{
		x = black[i][0];
		y = black[i][1];
		board[x][y].set(3);
	}*/

	//console.log("rozstawianie figur. ruch "+move);

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

function ability_fields(x, y)
{
	if (x==x1 && y==y1)
		{
			return 0;
		}

	if (board[x1][y1].value!=1 && ((x%10==0 && y%10==0) || (x==5 && y==5)))
		{
			board[x][y].notAble();
			return 0;
		}

	if (x1==x)
	{
		if (x==5 && board[x1][y1].value!=1 && Math.max(y1, y)>5 && Math.min(y1, y)<5)
		{
			board[x][y].notAble();
			return 0;
		}

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
	else if (y1==y)
	{
		if (y==5 && board[x1][y1].value!=1 && Math.max(x1, x)>5 && Math.min(x1, x)<5)
			{
				board[x][y].notAble();
				return 0;
			}

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
	//console.log("zxc"+move);
	if (x1==0 && y1==0) return 0;

	if (x1==x && y1==y)
	{
		board[x][y].ableCounter();
		x1=0;
		y1=0;
		return 0;
	}
	board[x][y].set(board[x1][y1].value);
	board[x1][y1].set(0);
	board[x1][y1].notAble();
	x1=0;
	y1=0;
	if_striking(x, y);
	if(x%10==0 || y%10==0) shieldwall(x, y, 0);
	if(x%8==1 || y%8==1) shieldwall(x, y, 1);
	move++;
	if (board[x][y].value==1) end(x, y);
	document.getElementById("current_player").innerHTML = players[move%2];
	if (typeof aiColor!=='undefined' && aiColor!==null && move%2==aiColor && move!=0) aiMove();
}

/**************************** bicie ***********************************/

function if_striking(x, y)
{
	if (x>1 && board[x-1][y].isThisMine()==0 && (board[x-2][y].isThisMine()==1 || (x==2 && y%10==0) || (x==7 && y==5 && board[5][5].value==0))) striking((x-1), y);
		if (x>0 && board[x-1][y].value==1) end(x-1, y);
	if (x<9 && board[x+1][y].isThisMine()==0 && (board[x+2][y].isThisMine()==1 || (x==8 && y%10==0) || (x==3 && y==5 && board[5][5].value==0))) striking((x+1), y);
		if (x<10 && board[x+1][y].value==1) end(x+1, y);
	if (y>1 && board[x][y-1].isThisMine()==0 && (board[x][y-2].isThisMine()==1 || (y==2 && x%10==0) || (y==7 && x==5 && board[5][5].value==0))) striking(x, (y-1));
		if (y>0 && board[x][y-1].value==1) end(x, y-1);
	if (y<9 && board[x][y+1].isThisMine()==0 && (board[x][y+2].isThisMine()==1 || (y==8 && x%10==0) || (y==3 && x==5 && board[5][5].value==0))) striking(x, (y+1));
		if (y<10 && board[x][y+1].value==1) end(x, y+1);
}

function striking(x, y)
{
		//jeśli zmienisz tablicę url, zmień tę funkcję
		//board.value 1 = na polu stoi król; 2 = na polu stoi obrońca króla; 3 = na polu stoi buntownik;

		if (board[x][y].value==1) {end(x,y); return 0};
		zbite[board[x][y].value%2]++;
		var side="";
		for (s=zbite[board[x][y].value%2]; s>0; s--)
		{
			side += url[board[x][y].value-1];	//
		}
		document.getElementById("side_"+(board[x][y].value-1)%2).innerHTML = side;
		board[x][y].set(0);
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

function end(x, y)	//przyjmuje położenie króla
{
	if (board[x][y].value!=1) return 0;
	if ((board[x-oneoneone(x)][y].value)%2+(board[x+oneone(x)][y].value)%2+(board[x][y-oneoneone(y)].value)%2+(board[x][y+oneone(y)].value)%2 == 4)
	{	alert('Król został zabity. Buntownicy zwyciężyli');	}
	else if (x%10==0 && y%10==0)
	{	alert('Król jest bezpieczny. Białe wygrały');	}
	else {	return 0;	}
	document.getElementById("board").innerHTML = "";
	move=0;
	//console.log("koniec gry");
	rysuj_plansze();
	x1=0;
	y1=0;
	return 1;
}
