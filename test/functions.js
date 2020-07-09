function findLastIndex(target,search){
  let lastIndex = -1;
  while(true){
     let position = search.indexOf(target, lastIndex + 1);
     if(position == -1){
         return lastIndex;
     }
     lastIndex = position;
 }
 return lastIndex;
}
/*
# Define a procedure, replace_spy,
# that takes as its input a list of
# three numbers, and modifies the
# value of the third element in the
# input list to be one more than its
# previous value.
*/
function replaceSpy(arrayName){
  arrayName[2] += 1;
  return arrayName;
}
/*
# Define a procedure, replace_spy,
# that takes as its input a list of
# three numbers, and modifies the
# value of the third element in the
# input list to be one more than its
# previous value.*/
function getArraySum(arrayName){
  let total = 0;
  for(let i=0,arrL = arrayName.length; i < arrL; i++){
    total += arrayName[i];
  }
  return total;
}