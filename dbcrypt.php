<?php
    define("SALT_LENGTH", 22); // Length of the Salt
     
    function encryptToHashWithSalt($str, $hash = 'sha256') {
        $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
        return hash($hash, $str . $salt);
    }
	
	function encryptToHashWithSaltAndBlowfish($str) {
	    if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
	        $salt = '$2y$15$' . substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
	        return crypt($str, $salt);
	    }
	}
	
	function verifyCryptation($str, $hash) {
    	return crypt($str, $hash) == $hash;
	}
?>