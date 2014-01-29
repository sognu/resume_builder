<?php
//Written by Chad Miller for CS 4540.  File represents an Archive.

// Get the utilities
require('application/utilities.php');

//Get the db.
require('application/db.php');

//Resume session and set buttons.
resumeSession();

//Set the session url.
$_SESSION['url'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

Admin_View();	


//View of the admin.
function Admin_View(){

	global $ch, $del, $delete_User, $change, $error_Admin;
	$name_Admin_View = array();
	$login_View = array();
	$role_View = array();
	//Resume session and set buttons.
	resumeSession();
	//Get button state.
	$buttons = getB_State_Admin();
	$delete_User = $buttons[0];
	$change = $buttons[1];
	validate_Admin();
	if($error_Admin == ''){
		if($change){

			//setParam('ch');
			Change($ch);
		}
		else if ($delete_User){

			//setParam('del');
			delete_User($del);
		}
	}
	try{
		// Open handle and start transaction
		$DBH = openDBConnection();
		$DBH->beginTransaction();

		$stmt = $DBH->prepare('select name, login, role from user;');
		$stmt->execute();
		$i= 0;
		while($row = $stmt->fetch())
		{
			$name_Admin_View[$i] = $row['name'];
			$login_View[$i] = $row['login'];
			$role_View[$i] = $row['role'];
			$i++;
		}
		// Commit the transaction
		$DBH->commit();
			
	}
		
	catch (PDOException $e) {
		$DBH->rollback();
		reportDBError($e);
	}
	
	if($_SESSION['role'] =='admin')
	require('views/admin.php');
}

	//Forward to login.
	if($_SESSION['loggedIn'] == false)
	header("Location:http://localhost:88/Projects/ps6/login.php");
	
	//Bad role.
	else if($_SESSION['loggedIn'] && $_SESSION['role'] != 'admin')
 	header("Location:http://localhost:88/Projects/ps6/role/badrole.php");
// }

?>