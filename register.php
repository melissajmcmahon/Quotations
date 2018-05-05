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
function registerMe() {
	var UN = document.getElementById("UN").value;
	var PW = document.getElementById("PW").value;
	var check = document.getElementById("check");
	 if (document.getElementById('UN').validity.valid && document.getElementById('PW').validity.valid ){
		 //alert("valid")
		 
		var anObj = new XMLHttpRequest();
		anObj.open("GET", "controller.php?UN=" + UN+"&PW="+PW, true);
		anObj.send();

 		anObj.onreadystatechange = function () {
			if (anObj.readyState == 4 && anObj.status == 200) {
				var curr = anObj.responseText;
				if(curr == "already here"){
				
					check.innerHTML = "<br>This account already exists.";
				//alert(curr);
				}
				else{
					window.location.href = 'quotes.php';
				}
		
			}
		}
	 }
	 else{
		 check.innerHTML = "<br>Please Fill out both fields <br> Username must be length 4 <br> Password must be length 6";
	 }
}

</script>
</body>
</html>