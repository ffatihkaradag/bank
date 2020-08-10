<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$settings['title']?></title>
</head>
<body>

<h3><a href="<?=$settings['baseURL']?>"><?=$settings['title']?></a></h3><hr>


<?php if(isset($_SESSION['message'])): echo $_SESSION['message']; endif; unset($_SESSION['message']); ?>