<?php

	require('../Database.php');
	require('../class/User.php');
	require('../class/Transaction.php');
	
	
	$db = new Database();
	
	$user = new User();
	
	$transaction = new Transaction();
	
	
	
	$settings = $db->settings();
	
	if(isset($_POST['register'])):
		
		$username = isset($_POST['username']) ? trim(strip_tags($_POST['username'])) : null;
		$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
		
		$password = isset($_POST['password']) ? trim(strip_tags($_POST['password'])) : null;
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
		
		$registerq = $user->register($username,$password);
		
		$register = json_decode($registerq,true);
		
		$_SESSION['message'] = $register['response']['message'];
		if($register['response']['code'] == 200):
			header('location:'.$settings['baseURL'].'/login.php');
		else:
			header('location:'.$settings['baseURL'].'/register.php');
		endif;
	endif;
	
	if(isset($_POST['login'])):
		
		$username = isset($_POST['username']) ? trim(strip_tags($_POST['username'])) : null;
		$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
		
		$password = isset($_POST['password']) ? trim(strip_tags($_POST['password'])) : null;
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
		
		$loginq = $user->login($username,$password);
		
		$login = json_decode($loginq,true);
		
		$_SESSION['message'] = $login['response']['message'];
		if($login['response']['code'] == 200):
			$_SESSION['uid'] = true;
			$_SESSION['userid'] = $login['user']['id'];
			header('location:'.$settings['baseURL']);
		else:
			header('location:'.$settings['baseURL'].'/login.php');
		endif;
		
	endif;
	
	
	if(isset($_POST['sendbalance'])):
		
		$toid = $_SESSION['userid'];
		$fromid = $_POST['fromid'];
		$balance = $_POST['balance'];
		
		$transaction = $transaction->transfer($toid,$fromid,$balance);
		
		$transaction = json_decode($transaction,true);
		
		$_SESSION['message'] = $transaction['response']['message'];
		
		if($transaction):
			header('location:'.$settings['baseURL']);
		endif;
		
	endif;
	