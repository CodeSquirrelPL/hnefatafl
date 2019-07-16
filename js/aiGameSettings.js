var aiColor=1;  //humanColor is unnecessary, because it's obvious: if ai plays white, human plays black, if ai plays black, human plays white
//0 - black, 1 - white
/*
Field.prototype.whoseCounter = function() //0 - empty field, 1 - black (zaczynają), 2 - white
{
  if (this.value==0) return 0;
  if (aiColor==1) { //if ai plays white
    if (this.value==2 || this.value==1) return 0;
    if (this.value==3) return 1;
  }
  else if (aiColor==0)  { //if ai plays black
    if (this.value==3) return 0;
    else if (this.value==2 || this.value==1) return 2;
  }
};*/
