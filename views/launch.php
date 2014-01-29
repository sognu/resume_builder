<script type="text/javascript" >
function OpenWindow() {
	var quantity = document.getElementById('quantity').value

	if ((quantity >= 1) && (quantity <= 10)) {
		window.open('http://www.something.com');
	} 
	else if ((quantity >= 11) && (quantity <= 20)) {
		window.open('http://www.somethingelse.com');
	} 
	else if ((quantity >= 21) && (quantity <= 30)) {
		window.open('http://www.anothersomething.com');
	} 
	else {
		window.open('http://www.gonowhere.com');
	}
}
</script>

<form action="result.php" method="post">
	Number: <input id="quantity" type="text" />
	<button type="button" onclick="OpenWindow()">Submit</button>
</form>