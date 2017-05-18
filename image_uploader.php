<?php
	/*
	 * Aggiungere i feedback alle azioni dell'utente.
	 * Implementare 'image from the web'.
	 * Abilitare/Disabilitare le due opzioni a seconda della selezione.
	 * Risolvere i punti sospesi in questi file [//temp].
	 * Risolvere il problema del percorso di root.
	 * 
	 * */

	 	//This is the directory where images will be saved
	if (session_id() == '') {
    	session_start();
    }	
	  
	$directory = "";
	 
	$path = $_FILES['userim']['name'];
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	
	include($directory . "dbuser.php");

	$target = $_SERVER['DOCUMENT_ROOT'] . "/gcr/user_images/"; //temp
	$target = $target . /*basename(*/$_SESSION["s_user_id"] . '_image.' . $ext; //temp
			
	// check for size
	if($_FILES["userim"]["size"] >= 1048576) {
		die();
	} else {
		$imageData = @getimagesize($_FILES["userim"]["tmp_name"]);
		$image_width = $imageData[0];
		$image_height = $imageData[1];
		
		if ($image_width != 128 && $image_height != 128) { // check for dimension 128x128
			die();
		}

		// check for image file
	    if($imageData === FALSE || !($imageData[2] == IMAGETYPE_GIF || $imageData[2] == IMAGETYPE_JPEG || $imageData[2] == IMAGETYPE_PNG)) {
			die();
	    }
	}
	
	if(move_uploaded_file($_FILES['userim']['tmp_name'], $target)) {
		//Tells you if its all ok
		// echo "The file ". basename( $_FILES['userim']['name']). " has been uploaded, and your information has been added to the directory";
	
		if($_SESSION["s_user_id"]) {
			 $dbuser -> uploadProfileImage($target, $_SESSION["s_user_id"]);
	
		}	
	
	} else {
		//Gives and error if its not
		// echo "error";
	}
	
	header("location: welcome.php");
?>