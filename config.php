<?php

//This function is used to create an id for the short url
function _getShorturlID($len){
	$mask = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$buffer = "";
	
	for($x = 0;$x<$len;$x++){
		$buffer .= $mask[rand(0,strlen($mask) -1)];
	}
	return $buffer;
}

$page_title = "URL Shortner";
$page_subHeader = "Use this URL Shortener service to shorten your long URLs!";
$shorturl_msg = "Here is your short url:";

$root_path = "//shorturl//";

$redirct_waitTime = 4;
?>