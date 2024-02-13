<?php

$to_mail = "nnt1927.3553@gmail.com";
$subject = "Email Verification";
$body = "Hi, This is an automatically generated email!";
$headers = "From: nileshthakurbgp@gmail.com";

if(mail($to_mail,$subject,$body,$headers)){
    echo "<h2>Mail Sent Successfully!";
}else{
    echo "<h2>Unsuccessful attempt!</h2>";
   print_r(error_get_last());
}



?>