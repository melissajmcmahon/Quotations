<!-- this file has the html code for the login page along with the ajax call to log the person in through the database. -->
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
<h1 class = 'myTitle'>Welcome Back!</h1>
<div class = "RLAHolder" id = "main">
Username: <input type = "text" id = "UN" placeholder = "Username" required> <br>
Password: <input type = "password" id = "PW" placeholder = "Password" required> <br> <br><br>
<input type = "button" value = "Submit" onclick = "login()">
<div id = "check">
</div>
</div>
<script>
function login() {
	//UNL gets the input from the UN input.
	var UNL = document.getElementById("UN").value;
	//PWL gets the input from the PW input.
	var PWL = document.getElementById("PW").value;	
	// check is a div that will be used to report error statements.
	var check = document.getElementById("check");
	if (document.getElementById("UN").validity.valid && document.getElementById("PW").validity.valid ){
		//checking if the user put input for all fields.	
		var anObj = new XMLHttpRequest();
		anObj.open("GET", "controller.php?UNL=" + UNL+"&PWL="+PWL, true);
		anObj.send();

 		anObj.onreadystatechange = function () {
			if (anObj.readyState == 4 && anObj.status == 200) {
				var curr = anObj.responseText;
				if(curr == "wrong"){
					// if the response text is 'wrong' the passwords did not match
					check.innerHTML = "Wrong Password.";
				}
				else if( curr == "empty"){
					// if the response text is an empty array, the username does not exist.
					check.innerHTML = "<br>Username does not exist."
				}
				else{
					// otherwise the login attempy was successful so go to the 'home page'
					window.location.href = 'quotes.php';
					
				}
		
			}
		}
	}
	else{
		// if the user did not fill out all fields, print an error message.
		 check.innerHTML = "<br>Please Fill out both fields.";
		}
}


</script>
</body>
</html>
