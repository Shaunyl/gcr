<?php
 	$directory = "";
	include ($directory . "dblayer.php");
?>

<?php
		
	class Map
	{
	  private $dblayer;

	  function __construct($dblayer) {
    	$this -> mysqli = Database::getInstance();
		$this -> dblayer = $dblayer;
  	  }
	  
	  public function readAll() {
	  	return $this -> dblayer -> read("map");
	  }
	  
	  public function readRange($offset, $count) {
	  	return $this -> dblayer -> readRange("map", $offset, $count);
	  }
	  
	  public function getSingle ($mapid) {
      	return $this -> dblayer -> readWhere(array("*"), "map", array("map_id" => $mapid));
	  }
	  
	  public function updateVoteVoters ($mapid, $vote, $voters) {
      	return $this -> dblayer -> updateWhere('map', array("vote" => $vote, "voters" => $voters), array("map_id" => $mapid));
	  }
	}
	
    $dbmap = new Map(new DbLayer());
?>









