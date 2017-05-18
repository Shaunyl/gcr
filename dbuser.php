<?php
    $directory = "";
    include ($directory . "dblayer.php");
?>

<?php
        
    class User
    {
      private $dblayer;

      function __construct($dblayer) {
        $this -> mysqli = Database::getInstance();
        $this -> dblayer = $dblayer;
      }
      
      public function getMaxId() {
        return $this -> dblayer -> read("user", array("MAX(user_id)"));
      }
      
      public function existUser($nickname) { // aggiustare condizioni OR e AND ...
        return $this -> dblayer -> readWhere(array("password", "user_id", "username"), "user", array("username" => $nickname, "email" => $nickname));
      }
      
      public function existEmail($email) {
        $result = $this -> dblayer -> readWhere(array("user_id"), "user", array("email" => $email));
        return ($result -> count());
      }
      
      public function write($username, $email, $password, $gender = null, $birth = null, $realname = null, $website = null, $location = null, $aboutme = null, $level = 'user') {
        $this -> dblayer -> write(array("username", "email", "password", "gender", "birth", "realname", "website", "location", "aboutme", "level")
            , "user", array($username, $email, $password, $gender, $birth, $realname, $website, $location, $aboutme, $level));
      }
      
      public function readProfile($userid) {
        return $this -> dblayer -> readWhere(array("website", "location", "birth", "realname", "aboutme", "date(regdate)", "lastlogin", "image", "gender", "email"), "user", array("user_id" => $userid));
      }
      
      public function getEmail ($userid) {
        return $this -> dblayer -> readWhere(array("email"), "user", array("user_id" => $userid));
      }
      
      public function getBirth ($userid) {
        return $this -> dblayer -> readWhere(array("birth"), "user", array("user_id" => $userid));
      }

      public function updateUsername($username, $userid) {
        return $this -> dblayer -> updateWhere('user', array("username" => $username), array("user_id" => $userid));
      }
      
      public function updateProfile($website, $location, $age, $realname, $gender, $userid) {
        return $this -> dblayer -> updateWhere('user', array("website" => $website, "location" => $location
            , "birth" => $age, "realname" => $realname, "gender" => $gender), array("user_id" => $userid));
      }

      public function updateAboutMe($aboutme, $userid) {
        return $this -> dblayer -> updateWhere('user', array("aboutme" => $aboutme), array("user_id" => $userid));
      }
       
      public function uploadProfileImage($image, $userid) {
        return $this -> dblayer -> updateWhere('user', array("image" => $image), array("user_id" => $userid));
      }
      
      public function updateLastSeen($lastseen, $userid) {
        return $this -> dblayer -> updateWhere('user', array("lastlogin" => $lastseen), array("user_id" => $userid));
      }
    }

    $dbuser = new User(new DbLayer());
?>









