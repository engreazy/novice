<?php
function findLastIndex($search,$target){
  $lastIndex = -1;
  while(true){
    $position = stripos( $search, $target);
    if($position == NULL){
      return $lastIndex;
    }
    $lastIndex = $position;
  }
  return $lastIndex;
}

# Define a procedure, replace_spy,
# that takes as its input a list of
# three numbers, and modifies the
# value of the third element in the
# input list to be one more than its
# previous value.
function replaceSpy($arrayName){
  $arrayName[2] += 1;
  return $arrayName;
}
# Define a procedure, sum_list,
# that takes as its input a
# list of numbers, and returns
# the sum of all the elements in
# the input list.
function sumList($arrayName){
  $total = 0;
  for($i = 0; $i < count($arrayName); $i++){
    $total += $arrayName[$i];
  }
  return $total;
}
# Define a procedure, measure_udacity,
# that takes as its input a list of strings,
# and returns a number that is a count
# of the number of elements in the input
# list that start with the uppercase
# letter 'U'.
function measureUdacity($arrayName){
  for($i = 0; $i < count($arrayName); $i++){
    if($arrayName[$i]){

    }
  }
}
echo "<pre>";
  print_r(
    replaceSpy([0,0,7])
  );
  echo "<br>";
  print_r(
    sumList([1,3,1,2])
  );
echo "</pre>";
