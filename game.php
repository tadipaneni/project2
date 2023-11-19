<?php session_start();
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="EN" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>poker dice</title>
<link rel = "stylesheet"
      type = "text/css"
      href = "pd.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">	  
</head>

<body>

<h1>Poker Dice</h1>

<div style="
    position: absolute;
    bottom: 5px;
    left: 40%;">
    <p>Rules:</p>
<img style = "   
height: 289px;
    " src="./dice_rules.jpeg">
</div>


<?php


//set things up if it's the first time here, otherwise play


function play(){
  //alternate control between firstPass and secondPass
  //functions based on $doNext
  $doNext = filter_input(INPUT_POST, "doNext");

  if ($doNext == "firstPass"){
    firstPass();
  } else {
    secondPass();
    evaluate();
  } // end if
} // end play

function startGame(){
  // if it's the first time here, set up initial cash,
  // and do firstPass
  $cash = 100;
  $_SESSION["cash"] = 100;
  firstPass();  
} // end reset

function firstPass(){
  $cash = $_SESSION["cash"];
  print <<< HERE
      <h2>First Pass</h2>
        
		<form method = "post"
        action = "">
    <fieldset class="container">

HERE;

  for ($i = 0; $i < 5; $i++){
    $die[$i] = rand(1, 6);
    //print "$i: $die[$i] ";
    print <<< HERE

      
        <img src = "die$die[$i].jpg";
             alt = "$i" />
        <input type = "checkbox"
               name = "keepIt[$i]"
               value = "$die[$i]" />
      
      
HERE;
   
  } // end for
  print <<< HERE
      <input type = "hidden"
             name = "doNext"
             value = "secondPass" />
             
      <button type = "submit" 
      style='
      color: #e4f0e6;
    font-weight: 800;
    font-size: large;
    background-color: #452515;
    border-radius: 7px;
      '>
        Roll the Dice
      </button>
      <p>Cash: $cash</p>
    </fieldset>
  </form>
  
HERE;
  $_SESSION["cash"] = $cash;
} // end firstPass

function secondPass(){
  global $die;
  //get cash from session variable
  $cash = $_SESSION["cash"];
  //print "cash: $cash <br />";
    
  print <<< HERE
  <h2>Second Pass</h2>
  
  <form method = "post"
        action = "">
    <fieldset class="container">

HERE;
  //check to see if keepIt exists 
  // (which happens if any of the checkboxes is checked)
  if (filter_has_var(INPUT_POST, "keepIt")){
    //pull all values from form
    $formVals = filter_input_array(INPUT_POST);
    //extract $keepIt array (easiest way to handle array input)
    $keepIt = $formVals["keepIt"];
  
    for ($i = 0; $i < 5; $i++){
      //if any values are empty, replace them with zero
      if (empty($keepIt[$i])){
        $keepIt[$i] = 0;
      } // end if
      //print "$i) $keepIt[$i] <br />";
    } // end for loop
  } else {
    //keepIt doesn't exist, so make it with
    //all zero values
    $keepIt = array(0, 0, 0, 0, 0);
  } // end if 
  
       
  for ($i = 0; $i < 5; $i++){
    //replace the image if the current value
    //of keepIt is non-zero
    if ($keepIt[$i] == 0){  
      $die[$i] = rand(1, 6);
    } else {
      $die[$i] = $keepIt[$i];
    } // end if
    
    print <<< HERE
      
        <img src = "die$die[$i].jpg";
             alt = "$i" />
			 
      
      
HERE;
   
  } // end for
  print <<< HERE
      <input type = "hidden"
             name = "doNext"
             value = "firstPass" />
      <button type = "submit"
      style='
      color: #e4f0e6;
    font-weight: 800;
    font-size: large;
    background-color: #452515;
    border-radius: 7px;
      '>
        Roll the Dice
      </button>
    </fieldset>
  </form>
  
  
HERE;

} // end secondPass

function evaluate(){
  global $die;
  //set up payoff
  $payoff = 0;
  //create $numVals
  for($i = 1; $i <= 6; $i++){
    $numVals[$i] = 0;
  } // end for loop
  
  
  //count the dice
  for ($theVal = 1; $theVal <= 6; $theVal++){
  	for ($dieNum = 0; $dieNum < 5; $dieNum++){
  	  if ($die[$dieNum] == $theVal){
  	    $numVals[$theVal]++;
  	  } // end if
  	} // end dieNum for loop
  } // end theVal for loop
  
  //print out results
  //  for ($i = 1; $i <= 6; $i++){
  //  	print "$i:  $numVals[$i]<br />\n";
  //  } // end for loop
  
  //count how many pairs, threes, fours, fives
  $numPairs = 0;
  $numThrees = 0;
  $numFours = 0;
  $numFives = 0;
  
  for ($i = 1; $i <= 6; $i++){
    switch ($numVals[$i]){
      case 2:
        $numPairs++;
        break;
      case 3:
        $numThrees++;
        break;
      case 4:
        $numFours++;
        break;
      case 5:
        $numFives++;
        break;
    } // end switch
  } // end for loop

  print "<p> \n";
  
  //check for two pairs
  if ($numPairs == 2){
    print "You have two pairs!<br />\n";
    $payoff = 1;
  } // end if
  
  //check for three of a kind and full house
  if ($numThrees == 1){
    if ($numPairs == 1){
      //three of a kind and a pair is a full house
      print "You have a full house!<br />\n";
      $payoff = 5;
    } else {
      print "You have three of a kind!<br />\n";
      $payoff = 2;
    } // end 'pair' if
  } // end 'three' if

  //check for four of a kind
  if ($numFours == 1){
    print "You have four of a kind!<br />\n";
    $payoff = 5;
  } // end if
  
  //check for five of a kind
  if ($numFives == 1){
    print "You got five of a kind!<br />\n";
    $payoff = 10;
  } // end if
  
  //check for straights
  if (($numVals[1] == 1)
    && ($numVals[2] == 1)
    && ($numVals[3] == 1)
    && ($numVals[4] == 1)
    && ($numVals[5] == 1)){
    print "You have a straight!<br />\n";
    $payoff = 10;
  } // end if

  if (($numVals[2] == 1)
    && ($numVals[3] == 1)
    && ($numVals[4] == 1)
    && ($numVals[5] == 1)
    && ($numVals[6] == 1)){
    print "You have a straight!<br />\n";
    $payoff = 10;
          
  } // end if
  $cash = $_SESSION["cash"];
  //print "Cash: $cash<br />\n";
  //subtract some money for this roll
  $cash -= 2;
  print "You bet 2<br />\n";
  print "Payoff is $payoff<br />\n";
  $cash += $payoff;
  print "Cash: $cash<br />\n";
	print "</p> \n "; 
	
	
	//store cash back to session:
	$_SESSION["cash"] = $cash;
} // end evaluate
print"<div>";

print"
<a href='Logout.php' 
style= '    
position: relative;
top: -75px;
left: 90%;
display: inline-block;
padding: 10px 20px;
color: #e4f0e6;
font-weight: 800;
font-size: large;
text-decoration: none;
background-color: #452515;
border-radius: 7px;
cursor: pointer;''
>Logout</a>";


if (filter_has_var(INPUT_POST, "doNext")){
play();

} else {
  startGame();
} // end if



$money=$_SESSION["cash"];
$user=$_SESSION['user'];
$text = "$user: $money";
echo"<p>Score:<br>$text</p>";

print"</div>";




		




?>
</body>
</html>

    