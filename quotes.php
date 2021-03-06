<!--  This file is the main page for the website. Contains the html along with the javascript/ajax function calls. -->
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<link rel='stylesheet' type='text/css' href='quoteStyle.css' />
<title>Quotation Service</title>
</head>
<body class = 'mainBody' onload="getAllQuotes()">
<h1 class = 'myTitle'>Quotation Service</h1>
<div class = 'tab'>
<h2 class = 'tabButton' onClick ="window.location.href = 'register.php'">Register</h2>
<h2 class = 'tabButton' onClick = "window.location.href = 'login.php'">Login </h2>
<h2 class = 'tabButton' onClick ="window.location.href = 'addQuotes.php'" >Add Quote</h2>
</div>

<?php 
// $userId = 
if (isset($_SESSION['currUser'])){
    ?>
    <div> 
    <br>
    <input type = 'button' value = "logout" onclick="logout()">
    <input type = 'button' value = 'unflag all' onclick = 'unflagAll()'>
    <br>
    </div> 
<?php 
}
?>
<div id = "change" class = "quoteHolder">
</div>
<script>
//get all quotes sets up the homepage according to the current database. If the quote is flagged, it will not show up. 
// The quotes show up with highest rating first, and then most recently added if ratings are the same.
function getAllQuotes(){
	// change is a div that will be updated based on the quotes, authors, and ratings in the database.
	div = document.getElementById("change");
	var anObj = new XMLHttpRequest();
	anObj.open("GET", "controller.php?all=" + "all", true);
	anObj.send();
	var myStr = "";

	  anObj.onreadystatechange = function () {
	      if (anObj.readyState == 4 && anObj.status == 200) {
	          var arr = JSON.parse(anObj.responseText);
	          for (var i = 0; i < arr.length; i++) {
	              var quote = arr[i]["quote"];
	              var author = arr[i]["author"];
			// myStr is a string that will hold the html code for the page as it ratings and quotes are added.
	              myStr+= "<div class = 'quote'>"+quote+"<br>"+
	              "--"+author+"<br><br>"+
	              "<input type = 'button' value = '+' onclick = 'changeRating("+ 1 + "," +arr[i]['id']+")'>"+
	              arr[i]['rating']+
	              "<input type = 'button' value = '-' onclick = 'changeRating("+ -1 + "," +arr[i]['id']+")'>"+
	              "<input type = 'button' value = 'flag' onclick = flagThis("+arr[i]['id']+")>"+
	              "</div>";
	              
	          }
		  // I make the string of html above, and then set it here as it avoided my page reloading and bringing 
		  // the user to the top each time an action was performed.
	          div.innerHTML = (myStr);
	        
	      }
	   }	
}
//changeRating takes in a positive or negative 1 along with a quote id, and passes them to an ajax call.			
function changeRating(num,id){
	var anObj = new XMLHttpRequest();
	anObj.open("GET", "controller.php?id=" + id+"&num="+num, true);
	anObj.send();

	  anObj.onreadystatechange = function () {
	      if (anObj.readyState == 4 && anObj.status == 200) {
	          var curr = anObj.responseText;
	          getAllQuotes();
			}
			
		}
	
}
// flagThis takes in a quote id and calls the ajax to change the boolean flagged in my database from 0 to 1. 
function flagThis(idF){
	var anObj = new XMLHttpRequest();
	anObj.open("GET", "controller.php?idF=" + idF, true);
	anObj.send();

	  anObj.onreadystatechange = function () {
	      if (anObj.readyState == 4 && anObj.status == 200) {
	          //var curr = anObj.responseText;
	          getAllQuotes();
			}
			
		}
}
//logout calls the ajax function to unset the current session.
	// on a look in, I shouldnt need to call ajax to unset my session and destroy it.
function logout(){
	var anObj = new XMLHttpRequest();
	anObj.open("GET", "controller.php?logout=" + "logout", true);
	anObj.send();

	  anObj.onreadystatechange = function () {
	      if (anObj.readyState == 4 && anObj.status == 200) {
	    	  	window.location.href = 'quotes.php';
			}
			
		}
}
// unflagAll calls an ajax function which changes all the 'flagged' booleans in my database to 0.
function unflagAll(){
	var anObj = new XMLHttpRequest();
	anObj.open("GET", "controller.php?unflag=" + "unflag", true);
	anObj.send();

	  anObj.onreadystatechange = function () {
	      if (anObj.readyState == 4 && anObj.status == 200) {
	    	  	getAllQuotes();
			}
			
		}
	
}

</script>
</body>
</html>
