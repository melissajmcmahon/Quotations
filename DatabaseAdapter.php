<?php
//Melissa McMahon
class DatabaseAdaptor {
    // The instance variable used in every one of the functions in class DatbaseAdaptor
    private $DB;
    // Make a connection to the data based named 'imdb_small' (described in project).
    public function __construct() {
        $db = 'mysql:dbname=quotes;host=127.0.0.1;charset=utf8';
        $user = 'root';
        $password = '';
        
        try {
            $this->DB = new PDO ( $db, $user, $password );
            $this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch ( PDOException $e ) {
            echo ('Error establishing Connection');
            exit ();
        }
    }
    //this function gets an array of quotes/authors from the database as long as its not flagged, and in order of
    // rating.
    public function getAllQuotes() {
        $stmt = $this->DB->prepare( 'SELECT * FROM quotations where flagged = 0 ORDER BY rating DESC, added DESC');
        $stmt->execute ();
        return $stmt->fetchAll ( PDO::FETCH_ASSOC );
    }
    //this function changes the rating in the database given a positive or negative 1 and the quote id.
    public function changeRating($quoteId,$addOrSub){
            $stmt = $this->DB->prepare("update quotations set rating = rating+". $addOrSub ." where id = ". $quoteId );
            $stmt->execute ();
    }
    // this adds a quote to the database given the quote and its id.
    public function addThisQuote($quote,$author){
        $stmt = $this->DB->prepare( "insert into quotations(quote, author, rating, flagged,added) values('".$quote."', '".$author."', 0, 0,Now())");
        $stmt->execute ();
    }
    // this function checks whether or not the username exists in the database.
    public function checkMe($UN){
        $stmt = $this->DB->prepare('SELECT username from users where username ="' .$UN.'"');
        $stmt->execute ();
        return $stmt->fetchAll ( PDO::FETCH_ASSOC );
    }
    // this function adds a new quote and hashed password to the database.
    public function registerMe($UN,$PWHASH){
        $stmt = $this->DB->prepare('insert into users(username, hash) values("'.$UN.'","'.$PWHASH.'")');
        $stmt->execute ();
    }
    //this function returns the hash password in order to check the if the login attempt is valid.
    public function getHash($UN){
        $stmt = $this->DB->prepare('select hash from users where username = "'.$UN.'";');
        $stmt->execute ();
        return $stmt->fetchAll ( PDO::FETCH_ASSOC );
    }
    // this function changes the flagged boolean in the database given a quote id.
    public function flagThis($idF){
        $stmt = $this->DB->prepare("update quotations set flagged = 1 where id = ".$idF);
        $stmt->execute ();
    }
    //this function returns a users id based off of the username.
    public function getId($UN){
        $stmt = $this->DB->prepare("select id from users where username = '".$UN."'");
        $stmt->execute ();
        return $stmt->fetchAll ( PDO::FETCH_ASSOC );
    }
    //this function goes through the database and changes all 'flagged' booleans to 0.
    public function unflagALL(){
        $stmt = $this->DB->prepare("update quotations set flagged = 0");
        $stmt->execute ();
    }
}
$theDBA = new DatabaseAdaptor ();
// Test code for some of the functions.
//$arr = $theDBA->getAllQuotes ( '*' );
//print_r ( $arr );
//$arr = $theDBA->changeRating ( 1 ,-1 );
//$arr = $theDBA->addThisQuote("sigh","Melissa");
//print_r ( $arr );
//$arr = $theDBA->checkMe("Addrasavvie");
//print_r($arr);
//$arr = $theDBA->registerMe("Addrasavvie","hashed2");
//$arr = $theDBA->getHash("Addrasavvie");
//print_r($arr);
//$arr = $theDBA->flagThis("8");
//$arr = $theDBA->getId("Addrasavvie");
?>
