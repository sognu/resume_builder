<!doctype html>

<html>

<head>
<title>Position Sought</title>
<link rel="stylesheet" type="text/css" href="application/style.css"/>
</head>

<body>

<h2>Position Sought</h2>

<ul>
<li> <a href="contact.php">Contact information</a> </li>
<li> <a href="history.php">Employment history</a></li>
<li> <a target="resume" href="resume.php">View resume</a></li>
<?php echo  $links?>
</ul>

<p>Please enter your contact information.</p>

<form method="post">

<table class="block">
 <tr>
   <td <?php validate('position') ?>>Position Sought</td>
   <td><textarea class="info" name="position"><?php sticky('position') ?></textarea></td>
 </tr>
</table>

<p>
<input type="submit" name="save" value="Save"/>
</p>

</form>
</body>
</html>
