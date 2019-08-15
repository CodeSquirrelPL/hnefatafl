var moves = new Array();

function aiMove() {
  countMoves(aiColor);
  randomMove();
  //console.log("wykonuję ruch: "+move);
  moves=0;
}

function countMoves(player) {
var counters
//var playerMoves = 0;
moves = new Array();

  for (i=0; i<11; i++)  {
    for (j=0; j<11; j++)  {
      //console.log(i+" "+j);
      //'<div class="board__cell" id="' + j + 'x' + i + '"';
      //1 = na polu stoi król; 2 = na polu stoi obrońca króla; 3 = na polu stoi buntownik
      //if (board[i][j].value) playerMoves=playerMoves+movesSinglePiece(i, j, player);
      if (board[i][j].value) movesSinglePiece(i, j, player);
    }
  }
//alert(playerMoves+" "+moves.length);
//alert(randomMove());
}

function movesSinglePiece(x, y, player) { // sprawdzanie możliwych ruchów dla jednego pionka
  if (board[x][y].value==0) return 0;
  if (player==0 && board[x][y].value!=3) return 0;
  if (player==1 && board[x][y].value!=1 && board[x][y].value!=2) return 0;
  var movesCounter = 0;

  for (a=x-1; a>=0; a--)  { //w lewo - oś x, minus
    if (board[a][y].value!=1 && i%10==0 && y%10==0) a=0;
    else if (board[a][y].value==0) {moves.push([x,y,a,y]); movesCounter++;}
    else a=0;
  }

  for (a=y-1; a>=0; a--)  { //w górę - oś y, minus
    if (board[x][y].value!=1 && a%10==0 && y%10==0) a=0;
    else if (board[x][a].value==0)  {moves.push([x,y,x,a]); movesCounter++;} //{console.log (x+","+y+" -> "+x+","+a); movesCounter++;}
    else a=0;
  }

  for (a=x+1; a<=10; a++)  { //w prawo - oś x, plus
    if (board[x][y].value!=1 && a%10==0 && y%10==0) a=10;
    else if (board[a][y].value==0) {moves.push([x,y,a,y]); movesCounter++;}
    else a=10;
  }

  for (a=y+1; a<=10; a++)  { //w dół - oś y, plus
    if (board[x][y].value!=1 && a%10==0 && y%10==0) {a=10;}
    else if (board[x][a].value==0)  {moves.push([x,y,x,a]); movesCounter++;}
    else a=10;
  }

  return movesCounter;
}


function randomMove() {

  var chosenMove;

  var min = Math.ceil(0);
  var max = Math.floor(moves.length-1);
  chosenMove =  Math.floor(Math.random() * (max - min + 1)) + min; //The maximum is inclusive and the minimum is inclusive
  console.log(chosenMove+" "+move);
  //return (moves[chosenMove][0]+","+moves[chosenMove][1]+" -> "+moves[chosenMove][2]+","+moves[chosenMove][3]);
  x1=moves[chosenMove][0];
  y1=moves[chosenMove][1];
  moving(moves[chosenMove][2], moves[chosenMove][3]);
}
