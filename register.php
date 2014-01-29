<?php 

// Get DB functions
require 'application/db.php';

// Helper functions
require 'application/utilities.php';

// // Authentication
// require 'application/authentication.php';

// Use HTTPS
//redirectToHTTPS();

resumeSession();

// If this is a submission, process it
$nameError = '';
$loginError = '';
$passwordError = '';

if(isset($_REQUEST['cancel'])){
	//Get the page of origin.
	$ref = $_SESSION['url'];	
	//Successfully registered send user to page of origin.
	header("Location:$ref");
}

if (isset($_REQUEST['name']) && isset($_REQUEST['password']) && isset($_REQUEST['login'])) {
	
	$name = trim($_REQUEST['name']);
	$login = trim($_REQUEST['login']);
	$password = trim($_REQUEST['password']);
	$password2 = trim($_REQUEST['password2']);
	
	// Register user if name, login, and password are provided
    	$isAdmin = isset($_REQUEST['admin']);
	if (registerNewUser($name, $login, $password, $isAdmin, $nameError, $loginError, $passwordError)) {
					
			if($isAdmin)
			$_SESSION['role'] = 'admin';
			else
			$_SESSION['role'] = 'user';
			
			//Get the page of origin.
			$ref = $_SESSION['url'];
			
			//Successfully registered send user to page of origin.
			header("Location:$ref");
		}
}

else {
	require 'views/register.php';
}

?>
