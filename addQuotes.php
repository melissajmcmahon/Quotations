<!-- This file holds the html code for the page 'add quote' and the call to add that quote to the database.  -->
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<link rel='stylesheet' type='text/css' href='quoteStyle.css' />
<title>AddQuote</title>
</head>
<body class = 'mainBody'>
<h1 class = 'myTitle'>Have Something to Add?</h1>
<div class ="RLAHolder">
Quote: <input type = "text" id = "quote" required pattern=".{1,}"> <br>
Author: <input type = "text" id = "author" required pattern=".{1,}"> <br> <br><br>
<input type = "button" value = "Submit" onclick = "addQuote()">
<div id = "change"> </div>
</div>
<script>
function addQuote() {
	// quote will hold the quote string input by the user.
	var quote = document.getElementById("quote").value;
	// quote will hold the author string input by the user.
	var author = document.getElementById("author").value;
	// check is a div that I will use to report error messages.
	var check = document.getElementById("change");
	if (document.getElementById("quote").validity.valid && document.getElementById("author").validity.valid ){
		// checking that the user put input into all required fields.
		var anObj = new XMLHttpRequest();
		anObj.open("GET", "controller.php?author=" + author+"&quote="+quote, true);
		anObj.send();
 		anObj.onreadystatechange = function () {
			if (anObj.readyState == 4 && anObj.status == 200) {
				// if we get to this point, the quote was logged into the database, so we can go back to
				// the quotes.php the 'home page'
				window.location.href = 'quotes.php';
				}
		
			}
		}
	else{
		// if they user didn't fill the input fields out correctly, they will get this error message.
		check.innerHTML = "<br>Both fields must be filled out."
	}
	
	}
</script>
</body>
</html>
