var zbite = [0, 0]; //które jest które? czarne 0, białe 1?
var i, j, x, y;
var style_throne = "background-image: url(img/throne.png)";
var style_x = "background-image: url(img/x.png)";
var url = ['<img src="img/king.svg" width="60" height="60"/>', '<img src="img/white.svg"  width="60" height="60"/>', '<img src="img/black.svg" width="60" height="60"/>']	//0 - król, 1 - biały pionek, 2 - czarny pionek
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
	document.getElementById(this.id).setAttribute("class", "square able");
	document.getElementById(this.id).setAttribute("onclick", "board["+this.x+"]["+this.y+"].chosing()");
};

Field.prototype.ableField = function()
{
	document.getElementById(this.id).setAttribute("class", "square able");
	document.getElementById(this.id).setAttribute("onclick", "moving("+this.x+", "+this.y+")");
};

Field.prototype.notAble = function()
{
	document.getElementById(this.id).setAttribute("class", "square");
	document.getElementById(this.id).setAttribute("onclick", "");
};

Field.prototype.abilityCounter = function()
{
	if (typeof aiColor!=='undefined' && aiColor!==null && move%2==aiColor) {this.notAble(); return 0;}

	if (this.whoseCounter()==(move%2)+1 && oneoneone(board[this.x-oneoneone(this.x)][this.y].value)+oneoneone(board[this.x+oneone(this.x)][this.y].value)+oneoneone(board[this.x][this.y-oneoneone(this.y)].value)+oneoneone(board[this.x][this.y+oneone(this.y)].value)+this.ifThrone() < 4)
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
	document.getElementById(this.id).setAttribute("class", "square chosen");
	document.getElementById(this.id).setAttribute("onclick", "moving("+this.x+", "+this.y+")");
};

Field.prototype.set = function(counter)
{
	this.value = counter;
	if (this.value!=0)
	document.getElementById(this.id).innerHTML = url[counter-1];
	else document.getElementById(this.id).innerHTML ="";
};

Field.prototype.whoseCounter = function() //0 - puste pole, 1 - czarne (zaczynają), 2 - białe
{
	if (this.value==0) return 0;
	if (this.value==3) return 1;
	else if (this.value==2 || this.value==1) return 2;
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
			plansza = plansza + '<div class="square" id="' + j + 'x' + i + '"';
			if ((i%10==0 && j%10==0) || (i==5 && j==5))
				plansza = plansza + ' style="'+style_throne+'"';
			else if ((i>2 && i<8 && j%10==0) || (j>2 && j<8 && i%10==0) || (i%8==1 && j==5) || (i==5 && j%8==1) || (i%4==3 && j==5) || (i==4 && j>3 && j<7) || (i==5 && j>2 && j<8) || (i==6 && j>3 && j<7))
				plansza = plansza + ' style="'+style_x+'"';
			plansza = plansza + ' onmouseover="ability('+j+', '+i+')"></div>';
		}

		plansza += '<div class="empty"></div>';
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
	}

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
	move++;
	if (board[x][y].value==1) end(x, y);
	document.getElementById("current_player").innerHTML = players[move%2];
	if (typeof aiColor!=='undefined' && aiColor!==null && move%2==aiColor && move!=0) aiMove();
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
		//jeśli zmienisz tablicę url, zmień tę funkcję
		//board.value 1 = na polu stoi król; 2 = na polu stoi obrońca króla; 3 = na polu stoi buntownik;

		if (board[x][y].value==1) {end(x,y); return 0};
		zbite[board[x][y].value%2]++;
		var side="";
		for (i=zbite[board[x][y].value%2]; i>0; i--)
		{
			side += url[board[x][y].value-1];	//
		}
		document.getElementById("side_"+(board[x][y].value-1)%2).innerHTML = side;
		board[x][y].set(0);
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
