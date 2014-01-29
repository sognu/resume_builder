<!--Written by Chad Miller for CS 4540.  File is view of Archive. -->
<!doctype html>

<html>
<head>
<title>Archive</title>
<link rel="stylesheet" type="text/css" href="application/style.css"/>
</head>

<body>

<h2>Archive</h2>

<ul>
<li> <a href="contact.php">Contact information</a> </li>
<li> <a href="history.php">Employment history</a></li>
<li> <a href="position.php">Position wanted</a></li>
<li> <a target="resume" href="resume.php">View resume</a></li>
<li> <a href= "logout.php">Logout</a></li>
</ul>

<p>Please enter a name for your resume between five and 20 letters.</p>

<Form method = 'post'>

<table class = "block">
<tr>
<td>Resume Name</td>
<td> <input  type = 'text' name = 'name_r'
value="<?php echo $name_r ?>"/></td>
<td><label for = "Caption" id = 'error' style="color:red"><?php echo $error ?></label></td>
</tr>
</table>

<table class = "buttons">
<tr>
<td><input type="submit" name="load" value="Load"/></td>
<td><input type="submit" name="store" value="Store"/></td>
<td><input type="submit" name="delete" value="Delete"/></td>
<td><input type="submit" name="view" value="View"/></td>
</tr>
</table>

</form>
</body>
</html>