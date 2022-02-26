<?php 

$fp=file("login.txt");

$words=array();
foreach($fp as $line){
    $words=explode(",",$line);
    echo "<br> <br> <hr>";
    echo "Visit Date : ".$words[0]."<br> Ip Address :".$words[1]."<br> Email : ".$words[2]." <br> Name : ".$words[3];

}


?>
