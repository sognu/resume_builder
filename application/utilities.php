<?php
//Written by Chad Miller for CS 4540.  File represents useful methods called within other files.


// Resumes a session; initializes session variables if necessary
// Reports whether this is a submission
function resumeSession () 
{
	if(session_id() == '')
	session_start();
	initSession('beg', array(''));
	initSession('end', array(''));
	initSession('job', array(''));
	initSession('name', '');
	initSession('address', '');
	initSession('phone', '');
	initSession('position', '');
	initSession('name_r', '');
	initSession('login', '');
	initSession('password', '');
	initSession('username', '');
	initSession('ch', '');
	initSession('del', '');
	initSession('url', '');
	initSession('role', '');
	initSession('loggedIn', false);
	return isset($_REQUEST['save']);
}


// Gets state of buttons for archive page.
function getB_State() 
{
	return (array (isset($_REQUEST['store']), isset($_REQUEST['delete']), isset($_REQUEST['load']), isset($_REQUEST['view'])));
}

//Gets state of buttons for admin page.
function getB_State_Admin(){
	return (array (isset($_REQUEST['delete_User']), isset($_REQUEST['change'])));
}

//Gets state of buttons for login page.
function getB_State_Login(){
	return (array (isset($_REQUEST['login']), isset($_REQUEST['cancel'])));
}


// If $param is not a session variable, create it with $default as its value
function initSession ($param, $default)
{
	if (!isset($_SESSION[$param]))
	{
		$_SESSION[$param] = $default;
	}
}

// Echoes a session variable
function sticky ($param)
{
	echo $_SESSION[$param];
}

// If the current request is a save, echoes "class=error" if
// the named session variable is the empty string
function validate ($param)
{
	global $isSubmission;
	if ($isSubmission && strlen($_SESSION[$param]) == 0)
	{
		echo "class='error'";
	}
}


// Sets $error if the resume name variable is not a letter between 5 - 20 characters.  'ctype_alpha' determines if string doesn't contain letters.
function validate_n(&$name_r, &$error)
{
	global $isStore, $isLoad, $isView, $isDelete, $isValid;
	$error = '';
	$name_r = '';
	if ($isStore || $isLoad || $isView || $isDelete){
		
	if (strlen(trim($_REQUEST['name_r'])) < 5 ||  strlen(trim($_REQUEST['name_r'])) > 20  || !ctype_alpha($_REQUEST['name_r']))
	{
		$error = 'Please enter valid name.';
	}
	else if($isStore){
		$_SESSION['name_r'] = $_REQUEST['name_r'];
		$name_r = $_SESSION['name_r'];
		
	}else{
		
		try{
			// Open handle and start transaction
			$DBH = openDBConnection();
			$DBH->beginTransaction();
		
			// Get userid
			$r = Exists('resume', $DBH, '');
		    if($r == NULL){
		    	$error = 'Resume does not exist';
		    }else{
		    	$_SESSION['name_r'] = $_REQUEST['name_r'];
		    	$name_r = $_SESSION['name_r'];
		    }
	
	}catch (PDOException $e) {
		$DBH->rollback();
		reportDBError($e);
	}
   }
}else
$name_r = $_SESSION['name_r'];
}

function validate_Admin(){
	
	global $change, $delete_User, $error_Admin, $ch, $del;
	$ch = '';
	$del = '';
	$error_Admin = '';
	if($change || $delete_User){
		
		if(isset($_REQUEST['delete_User'])){
			$del = $_REQUEST['del'];
		}else if (isset($_REQUEST['change'])){
			$ch = $_REQUEST['ch'];
		}
		
		try{
		// Open handle and start transaction
		$DBH = openDBConnection();
		$DBH->beginTransaction();
		// Get userid
		if($ch != '')
		$r = Exists('user', $DBH, $ch);
		else if ($del != '')
		$r = Exists('user', $DBH, $del);
		else $r = NULL;
		if($r == NULL){
			$error_Admin = 'User does not exist';
		
		}else if(isset($_REQUEST['change'])){
				$_SESSION['ch'] = $_REQUEST['ch'];
				$ch = $_SESSION['ch'];
				
	   }else if (isset($_REQUEST['delete_User'])){
	   	      $_SESSION['del'] = $_REQUEST['del'];
	   	      $del = $_SESSION['del'];   	
	   }
	
	}catch (PDOException $e) {
				$DBH->rollback();
				reportDBError($e);
			}
		
	}
}

// Return the value of the parameter $param if it exists.
// Otherwise, return $default.
function getParam ($param, $default)
{
	return (isset($_REQUEST[$param])) ? $_REQUEST[$param] : $default;
}

// Returns 'true' if this was a submission and $string is empty, returns 'false' otherwise.
function check ($string)
{
	global $isSubmission;
	return ($isSubmission && strlen($string) == 0) ? 'true' : 'false';
}

// Save parameters to a session.
function setParam($param){
	
$_SESSION[$param] = getParam($param, '');
	
}

//Determine which links to display.
function Links()
{
	
global $links;

if(!$_SESSION['loggedIn']){

$links .= "<li><a href= login.php >Login</a></li>";
$links  .= "<li><a href= register.php >Register</a></li>";
}
else if($_SESSION['role'] =='admin' && $_SESSION['loggedIn']){	

	$links  .= "<li><a href= archive.php>Archive</a></li>";
	$links  .= "<li><a href= admin.php>Admin</a></li>";
	$links  .= "<li><a href= logout.php id = 'logout'>Logout</a></li>";
}
else{	
	$links  .= "<li><a href= archive.php>Archive</a></li>";
	$links  .= "<li><a href= logout.php id = 'logout'>Logout</a></li>";
}
}


?>
