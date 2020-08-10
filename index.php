<?php
	require('Database.php');
	require('class/Transaction.php');
	require('class/User.php');

	$db = new Database();
	$user = new User();
	$transaction = new Transaction();
	
	$settings = $db->settings();
	
	include('inc/header.php');
	
	if(!isset($_SESSION['uid'])):
	
?>
<a href="<?=$settings['baseURL']?>/login.php">login</a>
<?php else: 


		
$cuser = json_decode($user->getUser($_SESSION['userid']),true); 
$allusers = json_decode($user->getUsers($_SESSION['userid']),true); 
$transactions = json_decode($transaction->all($_SESSION['userid']),true);
?>
<h3>Welcome back, <?=$cuser['user']['username']?>    <?=number_format($cuser['user']['balance'],2)?> TL</h3><hr>
<p>Send Money</p>
	<form action="<?=$settings['baseURL']?>/app/user.php" method="POST">
		<table>
			<tr>
				<td>
					<select name="fromid">
						<?php foreach($allusers['users'] as $user):?>
							<option value="<?=$user['id']?>"><?=$user['username']?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<input type="number" name="balance" required>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="sendbalance" value="send">
				</td>
			</tr>
		</table>
	</form>
<hr>
<p>Transaction History</p>

<table border="1">
	<tr>
		<th>ID</th>
		<th>To ID</th>
		<th>From ID</th>
		<th>Balance</th>
		<th>Date</th>
	</tr>
	<?php foreach($transactions['transactions'] as $transaction): ?>
	<tr>
		<td><?=$transaction['id']?></td>
		<td><?=$transaction['toid']?></td>
		<td><?=$transaction['fromid']?></td>
		<td><?=number_format($transaction['balance'],2)?> TL</td>
		<td><?=$transaction['created_at']?></td>
	</tr>
	<?php endforeach; ?>
</table>
		
		

<a href="<?=$settings['baseURL']?>/logout.php">logout</a>
<?php endif; ?>
<?php include('inc/footer.php'); ?>