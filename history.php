<?php

// Get the utilities
require('application/utilities.php');

// Resume session
$isSubmission = resumeSession();

// If this was a submission
if ($isSubmission)
{	
	// Get parameters
	$beg = getParam('beg', array());
    $end = getParam('end', array());
    $job = getParam('job', array());
    
    // Trim arrays to the same length and save to session
    $length = min(count($beg), count($end), count($job));
    $_SESSION['beg'] = array_slice($beg, 0, $length);
    $_SESSION['end'] = array_slice($end, 0, $length);
    $_SESSION['job'] = array_slice($job, 0, $length);  
}

// Compose JavaScript that will create job forms
$jobs = '';
for ($i = 0; $i < count($_SESSION['beg']); $i++) 
{
	$sVal = $_SESSION['beg'][$i];
	$eVal = $_SESSION['end'][$i];
	$jVal = $_SESSION['job'][$i];
	$jVal = strtr($jVal, array("\r" => "\\r",
			 				   "\n" => "\\n"));
    $sErr = check($sVal);
    $eErr = check($eVal);
    $jErr = check($jVal);
    $jobs .= "addJob('$sVal', '$eVal', '$jVal', $sErr, $eErr, $jErr);\n";
}

//Set the session url.
$_SESSION['url'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

//Set links.
Links();

// Output the HTML
require("views/history.php");

?>
