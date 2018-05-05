<?php
session_start();
// Melissa McMahon
include 'DatabaseAdapter.php';

//get all quotes and rating information from database.
if( isset($_GET['all'])) {
    $all = $_GET ['all'];
    $arr = $theDBA->getAllQuotes( $all );
    echo json_encode($arr);
}

// get the current rating and id of a quote.
else if( isset($_GET['num'])) {
     $rating = $_GET ['num'];
     $id = $_GET ['id'];
    $theDBA->changeRating( $id ,$rating);
}

// add this quote to the database, along with the author.
else if(isset($_GET['quote'])){
    $quote = $_GET['quote'];
    $author = $_GET['author'];
    $theDBA->addThisQuote($quote,$author);
}

// check if this username exists in the database already.
else if(isset($_GET['UN'])){
    $UN = $_GET['UN'];
   $arr = $theDBA->checkMe($UN);
   if(empty($arr)){
       //if it doesnt, salt and hash the password, then store it.
       $PWHASH = password_hash($PW,PASSWORD_DEFAULT);
       $theDBA->registerMe($UN,$PWHASH);
   }
   else {
       // otherwise throw an error.
       echo"already here";
   }
}

//check if this username exists.
else if(isset($_GET['UNL'])){
    $UNL = $_GET['UNL'];
    $PWL = $_GET['PWL'];
    $ID =  $theDBA->getId($UNL);
    $hashPass = $theDBA->getHash($UNL);
    // if it does not, throw an error, cannot login without registered account.
    if(empty($hashPass)){
        echo "empty";   
    }
    //otherwise check the verify password.
    else if(password_verify($PWL, $hashPass[0]["hash"])){
        // if the password verified, then set the session.
        $_SESSION['currUser'] = $ID[0]['id'];     
    }

     else {
         //otherwise, echo an error, wrong password.
        echo "wrong";
     }
    
}
// unset and destroy a session if the user chooses to logout.
    else if(isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['currUser']);
    }
    // flag a quote.
    else if(isset($_GET['idF'])){
        $idF = $_GET['idF'];
        $theDBA->flagThis($idF);
    }
    // unflag all quotes.
    else if (isset($_GET['unflag'])){
        $theDBA->unflagALl();
        
        
    }
?>