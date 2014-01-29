
<!doctype html>

<html>
<head>
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="application/style.css"/>
</head>

<body>

<h2>Admin</h2>

<ul>
<li> <a href="contact.php">Contact information</a> </li>
<li> <a href="history.php">Employment history</a></li>
<li> <a href="position.php">Position wanted</a></li>
<li> <a target="resume" href="resume.php">View resume</a></li>
<li> <a href= "logout.php">Logout</a></li>
</ul>

<form method = "post" >
<table id = "block2" border = '1'>
<tr><th>Name</th><th>Login</th><th>Role</th></tr>
<?php 
for ($i = 0; $i < count($name_Admin_View); $i++) 
{
    echo "<tr><td>$name_Admin_View[$i]</td> <td class = 'l'>$login_View[$i]</td> <td class = 'r'>$role_View[$i]</td></tr>";
}
?>
</table>
&nbsp;
<table class = "buttons">
<tr>
<td><input type="submit" name="delete_User" value="Delete"/></td>
<td> <input  type = 'text' name = 'del'
value="<?php echo $del ?>"/></td>
<td><input type="submit" name="change" value="Change"/></td>
<td> <input  type = 'text' name = 'ch'
value="<?php echo $ch ?>"/></td>
<td><label for = "Caption" style="color:red"><?php echo $error_Admin ?></label></td>
</tr>
</table>

</form>
</body>
</html>