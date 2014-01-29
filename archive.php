<?php
//Written by Chad Miller for CS 4540.  File represents an Archive.

//Get the db.
require('application/db.php');

//Get the utilities
require('application/utilities.php');

//Resume session and set buttons.
resumeSession();

//Set the session url.
$_SESSION['url'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];


//Get button state.
$buttons = getB_State();

$isStore = $buttons[0];
$isDelete = $buttons[1];
$isLoad = $buttons[2];
$isView = $buttons[3];

//Check submission is valid.
validate_n($name_r, $error);

//If this was a valid submission, save parameters to a session and store, delete, view, or load.
if($error == ''){
if($isStore){

setParam('name_r');
Store('resume');
}

else if ($isDelete){
	
setParam('name_r');
Delete();
}

else if ($isView){

setParam('name_r');
View();
}

else if ($isLoad){

setParam('name_r');
Load();
}
}

//Forward to login.
if($_SESSION['loggedIn'] == false)
header("Location:http://localhost:88/Projects/ps6/login.php");


//output the html
if(!$isView && $_SESSION['loggedIn'] || $isView && $error != '' && $_SESSION['loggedIn'])
require('views/archive.php');


?>