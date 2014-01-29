<?php
//Written by Chad Miller for CS 4540.  File represents an Archive.

//Get the utilities
require('application/utilities.php');


//require authentication
require('application/db.php');
// //require authentication
// require('application/authentication.php');

//Get button state.
$buttons = getB_State_Login();


$login= $buttons[0];
$cancel = $buttons[1];
$error_Login = '';

resumeSession();

//Get the page of origin.
$ref = $_SESSION['url'];

//If this was a valid submission, save parameters to a session and store, delete, view, or load.
if($login){

verifyLogin();
if($error_Login == '')
header("Location:$ref");

}
else if ($cancel){
header("Location:$ref");	

}

if(!$login && !$cancel)
require('views/login.php');
else if ($login && $error_Login != '')
require('views/login.php');
	
?>