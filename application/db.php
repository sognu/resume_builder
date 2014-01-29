<?php
//Written by Chad Miller for CS 4540.  File represents a database application.

require 'hidden/dbpassword.php';

require 'authentication.php';

function verifyLogin(){


	// Redirect to HTTPS
	//redirectToHTTPS();

	global $error_Login, $login, $cancel, $isAdmin, $loggedIn;
	$error_Login = '';

	if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];

		try{
			// Open handle and start transaction
			$DBH = openDBConnection();
			$DBH->beginTransaction();

			// Get userid
			$test = $DBH->prepare("select login, role, password from user where login = ?");
			$test->bindValue(1, $_REQUEST['username']);
			$test->execute();
			if($row = $test->fetch()){
				$loggedIn = true;
				// Validate the password
				$hashedPassword = $row['password'];
			
				//if (computeHash($password, $hashedPassword) == $hashedPassword) {

					$_SESSION['name'] = htmlspecialchars($row['name']);
					$_SESSION['username'] = $row['login'];
					$_SESSION['role'] = $row['role'];
					$_SESSION['loggedIn'] = true;

		        // }
// 				else
// 				{
// 					$error_Login = "Username or password are incorrect!!!!!!!.";
// 					$login = false;
// 					require "views/login.php";
// 					exit();
// 				}
			}
			else
			{
				$error_Login = "Username or password are incorrect.";
				$login = false;
				require "views/login.php";
				exit();
			}
		}

		catch (PDOException $exception) {
			require "views/error.php";
			exit();
		}

		// 	// We're logged in, so change session ID.  If the session ID was
		// 	// stolen before we switched to HTTPS, it will do no good now.
	  	//changeSessionID();
	}
}

// Opens and returns a DB connection
function openDBConnection () {
    global $dbpassword;
	$DBH = new PDO("mysql:host=atr.eng.utah.edu;dbname=ps6_chadm", 
			       'chadm', $dbpassword);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $DBH;
}



// Stores the current state of the session variables in the db.
function Store($table){
	
	try{
	// Open handle and start transaction
	$DBH = openDBConnection();
	$DBH->beginTransaction();
	
	// Get userid
	$r = Exists($table, $DBH, '');
		
	if($r == NULL){
		if($table == 'resume'){
		Insert('resume', $DBH);
		Insert('contact_info', $DBH);
		Insert('position_sought', $DBH);
		Insert('employment_history', $DBH);
		
		}
// 		else if ($table == 'user'){
			
// 			Insert('user', $DBH);
// 		}
	}
	else{
		Delete();
		if($table == 'resume'){
		Insert('resume', $DBH);
		Insert('contact_info', $DBH);
		Insert('position_sought', $DBH);
		Insert('employment_history', $DBH);
		
		}
// 		else if ($table == 'user'){
			
// 			Update('contact_info', $DBH);
// 		}
		
	}
	
	$DBH->commit();
	
	}
	catch (PDOException $e) {
		$DBH->rollback();
		reportDBError($e);
	}
	
}

//Returns true if the table contains an entry for the key.
function Exists($table, $DBH, $user){
	
	
	
	if($table == 'resume'){
	$test = $DBH->prepare("select id from resume where id = ?");
	$test->bindValue(1, $_REQUEST['name_r']);
	$test->execute();
	$row = $test->fetch();  
	return $row['id'];
	
	}
	
	else if ($table == 'user' && $user != ''){		
		$test = $DBH->prepare("select login from user where login = ?");
		$test->bindValue(1, $user);
		$test->execute();
		$row = $test->fetch();
		return $row['login'];
		
	} 
	else if ($table == 'user'){
		return NULL;
		
	}
}

//Inserts variables into a table where the primary key doesn't exist.
function Insert($table, $DBH){
	
   
	$inserted = '';
	
	if($table == 'resume'){
				
		// Record resume name for this session.
		$stmt = $DBH->prepare("insert into resume (id, password_r) values(?, ?)");
		$stmt->bindValue(1, $_SESSION['name_r']);
		$stmt->bindValue(2, $_SESSION['password']);
		$stmt->execute();	
		
		$inserted = $_SESSION['name_r'];
		
	}else if ($table == 'contact_info'){
		
		// Record contact info for this session.
		$stmt = $DBH->prepare("insert into contact_info (id_contact, name, phone, address) values(?, ?, ?, ?)");
		$stmt->bindValue(1, $_SESSION['name_r']);
		$stmt->bindValue(2, $_SESSION['name']);
		$stmt->bindValue(3, $_SESSION['phone']);
		$stmt->bindValue(4, $_SESSION['address']);
		$stmt->execute();
		
	}else if ($table == 'position_sought'){
		
		// Record posion_sought for this session.
		$stmt = $DBH->prepare("insert into position_sought (id_position, position) values(?, ?)");
		$stmt->bindValue(1, $_SESSION['name_r']);
		$stmt->bindValue(2, $_SESSION['position']);
		$stmt->execute();
		
		
	}else if ($table == 'employment_history'){
		
		// Record contact info for this session.
	for ($i = 0; $i < count($_SESSION['beg']); $i++)
		{
			$stmt = $DBH->prepare("insert into employment_history (id_employment, beg, end, job) values(?, ?, ?, ?)");
			$stmt->bindValue(1, $_SESSION['name_r']);
			
			$sVal = $_SESSION['beg'][$i];
			$eVal = $_SESSION['end'][$i];
			$jVal = $_SESSION['job'][$i];
		$stmt->bindValue(2, $sVal);
		$stmt->bindValue(3, $eVal);
		$stmt->bindValue(4, $jVal);
		$stmt->execute();
		}
			
	}	
}

//Updates into tables where the primary key already exists.
function Update($table, $DBH){
	
 if ($table == 'contact_info'){
	
		// Record contact info for this session.
		$stmt = $DBH->prepare("update contact_info set name = ?, phone = ?, address = ?  where id_contact = ?");
		$stmt->bindValue(1, $_SESSION['name']);
		$stmt->bindValue(2, $_SESSION['phone']);
		$stmt->bindValue(3, $_SESSION['address']);
		$stmt->bindValue(4, $_SESSION['name_r']);
		$stmt->execute();
	
	}else if ($table == 'position_sought'){
	
		// Record posion_sought for this session.
		$stmt = $DBH->prepare("update position_sought set position = ? where id_position = ?");
		$stmt->bindValue(1, $_SESSION['position']);
		$stmt->bindValue(2, $_SESSION['name_r']);
		$stmt->execute();
	
	
	}
			
		else if ($table == 'employment_history'){
			
			// Record contact info for this session.
			for ($i = 0; $i < count($_SESSION['beg']); $i++)
			{
			$stmt = $DBH->prepare("update employment_history set beg = ?, end = ?, job = ? where id_employment = ?");							
					$sVal = $_SESSION['beg'][$i];
					$eVal = $_SESSION['end'][$i];
					$jVal = $_SESSION['job'][$i];
					$stmt->bindValue(1, $sVal);
					$stmt->bindValue(2, $eVal);
					$stmt->bindValue(3, $jVal);
					$stmt->bindValue(4, $_SESSION['name_r']);
					$stmt->execute();
			}	
	
	}
}


// Deletes the entry from the db with the corresponding name.
function Delete(){
	
	try{
		// Open handle and start transaction
		$DBH = openDBConnection();
		$DBH->beginTransaction();
		
		$d = Exists('resume', $DBH, '');
		if($d == NULL){
			$error = 'Resume does not exist.';
			return;
		}
	
	$test = $DBH->prepare("delete from resume where id = ?");
	$test->bindValue(1, $_SESSION['name_r']);
	$test->execute();
	
	// Commit the transaction
	$DBH->commit();
	
	}
	   catch (PDOException $e) {
		$DBH->rollback();
		reportDBError($e);
	}
}


//Renders the entry from the db with the corresponding name to a resume.
function View(){


	try{
		// Open handle and start transaction
		$DBH = openDBConnection();
		$DBH->beginTransaction();
	
		// Get userid
		$r = Exists('resume', $DBH, '');

	  if($r != NULL){
			
	  	$stmt = $DBH->prepare('select name, phone, address from contact_info where id_contact = ? ');
	  	
	  	$stmt->bindValue(1, $_SESSION['name_r']);
	  	$stmt->execute();
	  	
	  	$results = $stmt->fetch();
	  	$name_View = $results['name'];
	  	$phone_View = $results['phone'];
	  	$address_View = $results['address'];
	  	
	  	$stmt2 = $DBH->prepare('select position from position_sought where id_position = ? ');	  	
	  	$stmt2->bindValue(1, $_SESSION['name_r']);
	  	$stmt2->execute();
	  	$results2 = $stmt2->fetch();
	  	$position_View = $results2['position'];
	  	
	  	$stmt3 = $DBH->prepare("select beg, end, job from employment_history where
	  			id_employment = ?");
	  	
	  	$stmt3->bindValue(1, $_SESSION['name_r']);
	  	$stmt3->execute();
	    $i = 0;
	    $beg_View = array();
	    $end_View = array();
	    $job_View = array();
	    while($row = $stmt3->fetch())
	  	{
	  	$beg_View[$i] = $row['beg'];
	  	$end_View[$i] = $row['end'];
	  	$job_View[$i]= $row['job'];
	  	$i++;
	  	}
		}
	
		//call javascript method launches views/view in new window.
		require('views/view.php');
		// Commit the transaction
		$DBH->commit();
	}
	   catch (PDOException $e) {
		$DBH->rollback();
		reportDBError($e);
	}
	
	
}

//Loads contact_info, position_sought, employment_history from the db into the session variables for the respective name.
function Load(){
	
	$error = '';

	try{
		// Open handle and start transaction
		$DBH = openDBConnection();
		$DBH->beginTransaction();
	
		// Get userid
		$r = Exists('resume', $DBH, '');
	
		if($r != NULL){
				
			$stmt = $DBH->prepare('select name, phone, address from contact_info where id_contact = ? ');
	
			$stmt->bindValue(1, $_SESSION['name_r']);
			$stmt->execute();
	
			$results = $stmt->fetch();
			$_SESSION['name'] = $results['name'];
			$_SESSION['phone'] = $results['phone'];
			$_SESSION['address']= $results['address'];
	
			$stmt2 = $DBH->prepare('select position from position_sought where id_position = ? ');
			$stmt2->bindValue(1, $_SESSION['name_r']);
			$stmt2->execute();
			$results2 = $stmt2->fetch();
			$_SESSION['position'] = $results2['position'];
	
			$stmt3 = $DBH->prepare("select beg, end, job from employment_history where
	  			id_employment = ?");
	
			$stmt3->bindValue(1, $_SESSION['name_r']);
			$stmt3->execute();
			
			$i = 0;		
			
			//Reset beg, end, job to empty.
			$_SESSION['beg'] = array();
			$_SESSION['end'] = array();
			$_SESSION['job'] = array();
			
			//Create beg, end, job.
			while($row = $stmt3 ->fetch()){								
				$_SESSION['beg'][$i] = $row['beg'];
				$_SESSION['end'][$i] = $row['end'];
				$_SESSION['job'][$i] = $row['job'];
				$i++;
			}		
		}
	
	
		// Commit the transaction
		$DBH->commit();
	}
	catch (PDOException $e) {
		$DBH->rollback();
		reportDBError($e);
	}	
	
}

//Changes the role of the user.
function Change($user){

	try{
		// Open handle and start transaction
		$DBH = openDBConnection();
		$DBH->beginTransaction();	
		$test = $DBH->prepare("select role from user where login = ?");
		$test->bindValue(1, $user);
		$test->execute();
	
		
		$results = $test->fetch();
		if($results['role'] == 'user'){
			
			$test = $DBH->prepare("update user set role = ? where login = ?");
			$test->bindValue(1, 'admin');
			$test->bindValue(2, $user);
			$test->execute();
			
		}else if ($results['role'] == 'admin'){
			
			$test = $DBH->prepare("update user set role = ? where login = ?");
			$test->bindValue(1, 'user');
			$test->bindValue(2, $user);
			$test->execute();
			
		}
		
		// Commit the transaction
		$DBH->commit();
	
	}
	catch (PDOException $e) {
		$DBH->rollback();
		reportDBError($e);
	}
	}
	
	

//Deletes the user.
function delete_User($user){

	try{
		// Open handle and start transaction
		$DBH = openDBConnection();
		$DBH->beginTransaction();
		$test = $DBH->prepare("delete from user where login = ?");
		$test->bindValue(1, $user);
		$test->execute();
	
		// Commit the transaction
		$DBH->commit();
	
	}
	catch (PDOException $e) {
		$DBH->rollback();
		reportDBError($e);
	}
	}
	

// Registers a new user
function registerNewUser ($name, $login, $password, $isAdmin) {
		try {
			$DBH = openDBConnection();
			$DBH->beginTransaction();
	
			$stmt = $DBH->prepare("insert into user (name, login, password, role) values(?,?,?,?)");
			$stmt->bindValue(1, $name);
			$stmt->bindValue(2, $login);
			$hashedPassword = computeHash($password, makeSalt());
			$stmt->bindValue(3, $hashedPassword);
			if($isAdmin){
			$stmt->bindValue(4, 'admin');
			}
			else {
			$stmt->bindValue(4, 'user');
			}
			
			$stmt->execute();
			$DBH->commit();
			return true;
		}
		catch (PDOException $e) {
			if ($e->getCode() == 23000) {
				return false;
			}
			reportDBError($e);
		}
	}
	

// Logs and reports a database error
function reportDBError ($exception) {
	$file = fopen("application/log.txt", "a");
	fwrite($file, date(DATE_RSS));
	fwrite($file, "\n");
	fwrite($file, $exception->getMessage());
	fwrite($file, "\n");
	fwrite($file, "\n");
	fclose($file);
	require "application/error.php";
	exit();
}





?>