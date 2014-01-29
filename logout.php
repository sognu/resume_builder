<?php

// Get the utilities
require('application/utilities.php');
resumeSession();
// Log out
unset($_SESSION['username']);
unset($_SESSION['name']);
$_SESSION['loggedIn'] = false; 
unset($_SESSION['role']);

header("Location:http://localhost:88/Projects/ps6/contact.php");
?>