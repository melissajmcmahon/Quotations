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
	var quote = document.getElementById("quote").value;
	var author = document.getElementById("author").value;
	var check = document.getElementById("change");
	//alert(quote);
	if (document.getElementById("quote").validity.valid && document.getElementById("author").validity.valid ){
		var anObj = new XMLHttpRequest();
		anObj.open("GET", "controller.php?author=" + author+"&quote="+quote, true);
		anObj.send();
 		anObj.onreadystatechange = function () {
			if (anObj.readyState == 4 && anObj.status == 200) {
				//var curr = anObj.responseText;
				window.location.href = 'quotes.php';
				}
		
			}
		}
	else{
		check.innerHTML = "<br>Both fields must be filled out."
	}
	
	}
</script>
</body>
</html>