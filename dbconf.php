<?php
    // Database configuration variables
    // $hostname = "localhost";
    // $username = "root";
    // $password = "dba";
    // $database = "test";
    
    // Creates a connection to the database
    // $connection = new mysqli ($hostname, $username, $password, $database) 
        // or die("Seems that something went wrong with the connection to the database.");
//     
    // // echo "<script type='text/javascript'>alert('Connected');</script>";
//     
    // // Checks if the connections was set successfully   
    // if ($connection -> connect_error) {
        // die ('Connect Error (' . $connection -> connect_errno . ') ' . $mysqli -> connect_error);
    // } 
    // else {
        // $_SESSION['connection'] = $connection;
    // }
   define("HOST", "localhost");
   define("USER", "root");
   define("PASSWD", "dba");
   define("DATABASE", "test");
    
   class Database extends MySQLi {

     // private $hostname = "localhost";
     // private $username = "root";
     // private $password = "dba";
     // private $database = "test";

     private static $instance = NULL;
     // private $connection;

     private function __construct($hostname, $username, $password, $database) {
         parent::__construct($hostname, $username, $password, $database);
         // $this -> connection = (new MySQLi($hostname, $username, $password, $database)
            // or die("Seems that something went wrong with the connection to the database."));
         // if ($this -> connection -> connect_error) {
             // die ('Connect Error (' . $connection -> connect_errno . ') ' . $this -> connection -> connect_error);
         // } 
     }
 
     public function __destruct() {
         self::$instance -> close();
     }

     public static function getInstance() {
         if (self::$instance == NULL){
             self::$instance = new self(HOST, USER, PASSWD, DATABASE);
         }
         return self::$instance;
     }
   }  
?>