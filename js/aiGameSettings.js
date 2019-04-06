var aiColor=1;  //humanColor is unnecessary, because it's obvious: if ai plays white, human plays black, if ai plays black, human plays white
//0 - czarne, 1 - białe
/*
Field.prototype.whoseCounter = function() //0 - puste pole, 1 - czarne (zaczynają), 2 - białe
{
  if (this.value==0) return 0;
  if (aiColor==1) { //jeśli ai gra białymi
    if (this.value==2 || this.value==1) return 0;
    if (this.value==3) return 1;
  }
  else if (aiColor==0)  { //jeśli ai gra czarnymi
    if (this.value==3) return 0;
    else if (this.value==2 || this.value==1) return 2;
  }
};*/
