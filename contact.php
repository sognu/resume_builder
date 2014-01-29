<?php

// Get the utilities
require('application/utilities.php');



// Start/resume session
$isSubmission = resumeSession();

// If this was a submission, save parameters to session
if ($isSubmission) 
{	
	$_SESSION['name'] = getParam('name', '');
    $_SESSION['address'] = getParam('address', '');
    $_SESSION['phone'] = getParam('phone', '');
}

//Set the session url.
$_SESSION['url'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

//Set links.
Links();

// Output the HTML
require("views/contact.php");


?>
