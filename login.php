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
	var UNL = document.getElementById("UN").value;
	var PWL = document.getElementById("PW").value;	
	var check = document.getElementById("check");
	if (document.getElementById("UN").validity.valid && document.getElementById("PW").validity.valid ){
		//alert("valid")
		var anObj = new XMLHttpRequest();
		anObj.open("GET", "controller.php?UNL=" + UNL+"&PWL="+PWL, true);
		anObj.send();

 		anObj.onreadystatechange = function () {
			if (anObj.readyState == 4 && anObj.status == 200) {
				var curr = anObj.responseText;
				//alert(curr);
				if(curr == "wrong"){
					//alert(curr);
					check.innerHTML = "Wrong Password.";
				}
				else if( curr == "empty"){
					check.innerHTML = "<br>Username does not exist."
				}
				else{					
					window.location.href = 'quotes.php';
// 					var main = document.getElementById("main");
 					//getAllQuotesForUser();
					//alert(curr);
					
				}
		
			}
		}
	}
	else{
		//alert("not valid")
		 check.innerHTML = "<br>Please Fill out both fields.";
		}
}


</script>
</body>
</html>