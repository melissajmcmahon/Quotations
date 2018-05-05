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
function getAllQuotes(){
	div = document.getElementById("change");
	var anObj = new XMLHttpRequest();
	anObj.open("GET", "controller.php?all=" + "all", true);
	anObj.send();
	var myStr = "";

	  anObj.onreadystatechange = function () {
	      if (anObj.readyState == 4 && anObj.status == 200) {
	          var arr = JSON.parse(anObj.responseText);
	          //alert(arr);
	          for (var i = 0; i < arr.length; i++) {
	              var quote = arr[i]["quote"];
	              //alert(quote);
	              var author = arr[i]["author"];
	              myStr+= "<div class = 'quote'>"+quote+"<br>"+
	              "--"+author+"<br><br>"+
	              "<input type = 'button' value = '+' onclick = 'changeRating("+ 1 + "," +arr[i]['id']+")'>"+
	              arr[i]['rating']+
	              "<input type = 'button' value = '-' onclick = 'changeRating("+ -1 + "," +arr[i]['id']+")'>"+
	              "<input type = 'button' value = 'flag' onclick = flagThis("+arr[i]['id']+")>"+
	              "</div>";
	              
	          }
	          div.innerHTML = (myStr);
	        
	      }
	   }	
}
			
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