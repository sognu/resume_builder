<!--Written by Chad Miller for CS 4540.  File is view of Login. -->
<!doctype html>

<html>
<head> 
<title>Login</title>
<link rel="stylesheet" type="text/css" href="application/style.css"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> 
</head>
<body>

<h2>Login</h2>

<form method = "post" >
<table class = "block">
<tr>
<td>Username</td>
<td> <input  type = 'text' name = 'username'/></td>
<td>Password</td>
<td> <input  type = 'password' name = 'password'/></td>
<td><label for = "Caption" style="color:red"><?php echo $error_Login ?></label></td>
</tr>
</table>

<table class = "buttons">
<tr>
<td><input type="submit" name="login" value="Login"/></td>
<td><input type="submit" name="cancel" value="Cancel" /></td>
</tr>
</table>

</form>
</body>
</html>