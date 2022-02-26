<?php

$messages = array();

if(isset($_POST["submit"])){
    foreach($_POST as $element){
        if( empty($element)){
            $messages[]= "All Fileds are required";
        }
    }
    $username=$_POST["name"];
    $email=$_POST["email"];
    $message=$_POST["message"];

    // valid name
    if(isset($username) && strlen($username)>0){

        if(strlen($username) > 100){
            $messages[]="Username length Must be less than 100 char";
        }
    }else{
        $messages[]="Username is Required";
    }

    // valid email
    if(isset($email) && strlen($email)>0){
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $messages[]="Email Format isn't valid";

        }
    }
    else{
        $messages[]="Email is Required"; 
    }

    // valid message(textfield)
    if(isset($message) && strlen($message)>0){
        if(strlen($message)>255){
            $messages[]="Message length must be less than 255 char";

        }
    }
    else{
        $messages[]="message is Required"; 
      }
    //All_Feild_is_full
    if(empty($messages)){
        $userip=$_SERVER['REMOTE_ADDR'];
        $line=array(date("F d Y h:i A"),$userip,$email,$username);
        $userdata=implode(",",$line);
        $fp=fopen("login.txt","a+");
        fwrite($fp,$userdata.PHP_EOL);
        fclose($fp); 

        session_start();
        if(!isset($_SESSION["is_visited"])){
            $_SESSION["is_visited"]=true;
            
            die("<Center> <b> $username First visit <br>  Thank You for submitting form!</Center>");

        }
        else{
            $_SESSION["counter"]=isset($_SESSION["counter"]) ? $_SESSION["counter"]+1 : 2;
            die("<Center> <b> you visit this page ".$_SESSION["counter"]."  times </Center>"."<center> <br/> Thank You for submitting form!</center>");
        }
    }
}//end submit form    


// get Data
function get_default($field){
    if(isset($_POST[$field])){
        echo $_POST[$field];
    }
    else{
        echo "";
    }
}
// $resetdata=$_POST["clear"];
// echo "$resetdata";

// reset data

// if(isset($_POST["clear"])){
//     foreach($_POST as $element){
//         echo "<br> Clear $element";
//         if(!empty($element)){
//             $messages[]= "Reset form";
//             $element=" ";
//         }
        
//     }   
// }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title> contact form </title>


    </head>

    <body>
        
        <h3> Contact Form </h3>
        
        <div id="after_submit">
        <?php foreach($messages as $line){ echo "* $line <br/>";}  ?>
        </div>
        <form id="contact_form" action="#" method="POST" enctype="multipart/form-data">

            <div class="row">
                <label class="required" for="name">Your name:</label><br />
                <input id="name" class="input" name="name" type="text" value="<?php get_default("name") ?>" size="30" /><br />

            </div>
            <div class="row">
                <label class="required" for="email">Your email:</label><br />
                <input id="email" class="input" name="email" type="text" value="<?php get_default("email") ?>" size="30" /><br />

            </div>
            <div class="row">
                <label class="required" for="message">Your message:</label><br />
                <textarea id="message" class="input" name="message" value="<?php get_default("message") ?>" rows="7" cols="30"></textarea><br />

            </div>

            <input id="submit" name="submit" type="submit" value="Send email" />
            <input id="clear" name="clear" type="reset" value="clear form" />

        </form>
    </body>

</html>