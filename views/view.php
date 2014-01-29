<!--Written by Chad Miller for CS 4540.  File is view of resume when 'View' is clicked. -->
<!doctype html>

<html>
<head>
<link rel="stylesheet" type="text/css" href="application/style.css"/>
</head>

<body>

<h3><?php echo $name_View?><br/>
    <?php echo $address_View ?><br/>
    <?php echo $phone_View ?></h3>
    
<h4>Position Desired</h4>
<p><?php echo $position_View ?></p>

<h4>Employment History</h4>

<ul>
<?php 
for ($i = 0; $i < count($beg_View); $i++) 
{
    echo "<li>$beg_View[$i]--$end_View[$i].  $job_View[$i]</li>";
}
?>
</ul>
</body>
</html>
