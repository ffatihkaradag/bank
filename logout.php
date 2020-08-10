<?php
	require('Database.php');

	$db = new Database();
	
	$settings = $db->settings();
	
	session_destroy();
	
	header('location:'.$settings['baseURL']); 
?>