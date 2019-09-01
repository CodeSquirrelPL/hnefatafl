
var i, j, x, y;
var x1=0, y1=0;
var style_throne = "background-image: url(img/throne.png)";
var style_x = "background-image: url(img/x.png)";
var url = ['<img src="img/king.svg" class="gamepiece_img" alt="król - biały, okrągły pionek z szarym krzyżykiem na środku"/>', '<img src="img/white.svg"  class="gamepiece_img" alt="biały, okrągły pionek"/>', '<img src="img/black.svg" class="gamepiece_img" alt="czarny, okrągły pionek"/>']	//0 - król, 1 - biały pionek, 2 - czarny pionek



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
	$('#'+this.id).attr("class", "board__cell able");
	$('#'+this.id).attr("onclick", "board["+this.x+"]["+this.y+"].chosing()");
};

Field.prototype.ableField = function()
{
	$('#'+this.id).attr("class", "board__cell able");
	$('#'+this.id).attr("onclick", "moving("+this.x+", "+this.y+")");
};

Field.prototype.notAble = function()
{
	$('#'+this.id).attr("class", "board__cell");
	$('#'+this.id).attr("onclick", "");
};

Field.prototype.chosing = function()
{
	x1 = this.x;
	y1 = this.y;
	$('#'+this.id).attr("class", "board__cell chosen");
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

/**************************** rysowanie planszy *****************************************/

function rysuj_plansze()
{
	$('#side_1').html("");
	$('#side_0').html("");
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

	$('#board').html(plansza);
  rozstaw_figury();
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
