<?php
	require('Database.php');
	require('class/Transaction.php');

	$db = new Database();
	
	$settings = $db->settings();
	
	include('inc/header.php');
	
	if(!isset($_SESSION['uid'])):
?>


	<form action="<?=$settings['baseURL']?>/app/user.php" method="POST">
		<table>
			<tr>
				<td>username</td>
				<td><input type="text" name="username" required></td>
			</tr>
			<tr>
				<td>password</td>
				<td><input type="password" name="password" required></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="login" name="login"> <a href="<?=$settings['baseURL']?>/register.php">register</a></td>
			</tr>
		</table>
	</form>
<?php include('inc/footer.php');  else: header('location:'.$settings['baseURL']); endif;?>