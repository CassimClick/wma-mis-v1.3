<?php
function dateFormatter($actualDate)
{
    $date = strtotime($actualDate);
    return date("d M Y", $date);
}


 function timeDifference($t1,$t2){
    $t1To24 = date("H:i", strtotime($t1));
    $t2To24 = date("H:i", strtotime($t2));
    $time1 = strtotime($t1To24);  
    $time2 = strtotime($t2To24);  
    $difference =  (($time1 - $time2)/60)/60;

   return abs((int)$difference);

 }

 function to24Hours($time){
  return  date("H:i", strtotime($time));
 }