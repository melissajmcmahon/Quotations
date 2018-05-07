<!-- This page contains the HTML code for the register page of the website along with the javascript/ajax call to register the
user into the database.-->
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
<h1 class = 'myTitle'>Want to Join?</h1>
<div class = "RLAHolder">
<!--<form onsubmit = "registerMe()">-->
Username: <input type = "text" id = "UN" placeholder = "Username" required pattern=".{4,}"> <br>
Password: <input type = "password" id = "PW" placeholder = "Password" required pattern=".{6,}"> <br><br>
<input type = "button" value = "Submit" onclick = "registerMe()" >
<!-- </form> -->
<div id = "check">
</div>
</div>
<script>
// registerMe calls an ajax function to do the necessary error checking and database updating in order to register a user.
function registerMe() {
	// UN will hold the users desired Username as a string.
	var UN = document.getElementById("UN").value;
	// PW will hold the users desired Password as a string.
	var PW = document.getElementById("PW").value;
	// check is a div that will allow for error messages to show up.
	var check = document.getElementById("check");
	 if (document.getElementById('UN').validity.valid && document.getElementById('PW').validity.valid ){
		 // checking if all fields were submitted and with the correct pattern.
		var anObj = new XMLHttpRequest();
		anObj.open("GET", "controller.php?UN=" + UN+"&PW="+PW, true);
		anObj.send();
 		anObj.onreadystatechange = function () {
			if (anObj.readyState == 4 && anObj.status == 200) {
				var curr = anObj.responseText;
				// if the response text is 'already here' then this username/account already exists, don't want
				// to create duplicate accounts in the database.
				if(curr == "already here"){				
					check.innerHTML = "<br>This account already exists.";
				}
				else{
					//otherwise, controller.php will have registered the account into the database, so send
					// the user to the home page.
					window.location.href = 'quotes.php';
				}
		
			}
		}
	 }
	 else{
		 // if the user did not fill out the form to the desired pattern, or left fields blank, throw an error.
		 check.innerHTML = "<br>Please Fill out both fields <br> Username must be length 4 <br> Password must be length 6";
	 }
}

</script>
</body>
</html>
