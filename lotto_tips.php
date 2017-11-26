<?php
header('Content-type: text/json');
// $numbers = range(1, 20);
// shuffle($numbers);

// function RandomNumbers($min, $max, $quantity) {
    // $numbers = range($min, $max);
    // shuffle($numbers);
    // return array_slice($numbers, 0, $quantity);
// }

// $random['random'] = RandomNumbers(1,58,6);
// echo json_encode($random);
?>

<?php

$num6=range(1,58);
$num3=range(0,9);
$num2=range(1,31);
shuffle($num6);
shuffle($num3);
shuffle($num2);
$digit_6 = array();
$digit_3 = array();
$digit_2 = array();

for ($x=0; $x< 6; $x++)
{

 $digit_6 = array_merge($digit_6, array (('Digit'.($x+1) )=> $num6[$x]));

}

for ($x=0; $x< 3; $x++)
{
  $digit_3 = array_merge($digit_3, array (('Digit'.($x+1) )=> $num3[$x]));

}

for ($x=0; $x< 2; $x++)
{
$digit_2 = array_merge($digit_2, array (('Digit'.($x+1) )=> $num2[$x]));

}

$date = date("M d, Y");
//$date = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$pm_tip = array('6-digit'=>$digit_6, '3-digit'=>$digit_3, '2-digit'=>$digit_2);
//$random['6_digit'] = $digit_6;
//$random1['3_digit'] = $digit_3;
//$random2['2_digit'] = $digit_2;
//echo json_encode($random);

$result = array(
		'date' => ($date),
        'result' => array($pm_tip)
		);
		
		
	     echo json_encode($result);	
		 
?>