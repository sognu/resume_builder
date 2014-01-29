<!doctype html>

<html>

<head>
<title>Employment History</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script>

$(function () {
	// Make the X button delete the block of controls in which it appears.
	$("input[value='X']").click(function () 
			{$(this).parents(".block").remove();});

	// Make the "Add Job" button add a new block of controls
	$("input[value='Add Job']").click(function () 
			{addJob('', '', '', false, false, false);});

	// Clone, then remove, the existing block of controls
	$history = $(".block").clone(true);
	$(".block").remove();

	// PHP inserts zero or more addJob(...) calls before the page is served
	<?php echo $jobs; ?>
});

// Add a new block of controls after initializing them properly.
function addJob (beg, end, job, sErr, eErr, jErr) {
	$newHistory = $history.clone(true);
	$newHistory.find("input[name='beg[]']").val(beg);
	$newHistory.find("input[name='end[]']").val(end);
	$newHistory.find("textarea[name='job[]']").append(job);
	if (sErr) $newHistory.find(".beg").attr("class", "error");
	if (eErr) $newHistory.find(".end").attr("class", "error");
	if (jErr) $newHistory.find(".job").attr("class", "error");
	$("#history").append($newHistory);
}
</script>
<link rel="stylesheet" type="text/css" href="application/style.css"/>
</head>

<body>

<h2>Employment History</h2>

<ul>
<li> <a href="contact.php">Contact information</a> </li>
<li> <a href="position.php">Position wanted</a></li>
<li> <a target="resume" href="resume.php">View resume</a></li>
<?php echo  $links?>
</ul>

<p>Please enter your employment history.  You can provide information on
any number of jobs you have held.</p>

<form method="post">

<div id="history">

<table class="block">
 <tr>
   <td class="beg">Start Date</td>
   <td><input class="date" type="text" name="beg[]"/></td>
   <td class="remove" rowspan="2"><input type="button" value="X"/></td>
 </tr>
 <tr>
  <td class="end">End Date</td>
  <td><input class="date" type="text" name="end[]"/></td>
 </tr>
 <tr>
  <td class="job">Job</td>
  <td colspan="2"><textarea class="info" name="job[]"></textarea></td>
 </tr>
</table>

</div>

<p>
<input type="button" value="Add Job"/>
<input type="submit" name="save" value="Save"/>
</p>

</form>
</body>
</html>
