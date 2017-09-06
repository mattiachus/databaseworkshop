<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>

<?php
	
if($cmd = filter_input(INPUT_POST, 'cmd')){
	if($cmd == 'change_language'){
		
		$cid = filter_input(INPUT_POST, 'languageid', FILTER_VALIDATE_INT)
			or die('Missing/illegal languageid parameter');
		$cnam = filter_input(INPUT_POST, 'languagename')
			or die('Missing/illegal languagename parameter');
		
		require_once('dbcon.php');
		$sql = 'UPDATE language SET name=? WHERE language_id=?';
		$stmt = $link->prepare($sql);
		$stmt->bind_param('si', $lnam, $lid);
		$stmt->execute();
		
		if($stmt->affected_rows > 0){
			echo 'Language changed!!!';
		}
		else{
			echo 'Nothing was changed ?!?!?!';
		}
		
	}
	else {
		die('Unknown cmd parameter');
	}
}
?>


	<h1>Rename category</h1>
<?php
	
	if(empty($lid)){
		$cid = filter_input(INPUT_GET, 'languageid', FILTER_VALIDATE_INT)
			or die('Missing/illegal categoryid parameter');
	}
	
	require_once('dbcon.php');
	$sql = 'SELECT name FROM language WHERE language_id=?';
	$stmt = $link->prepare($sql);
	$stmt->bind_param('i', $cid);
	$stmt->execute();
	$stmt->bind_result($cnam);
	while($stmt->fetch()) {}
	
	?>
	
<p>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<fieldset>
    	<legend>Rename category</legend>
    	<input name="languageid" type="hidden" value="<?=$lid?>" />
    	<input name="languagename" type="text" value="<?=$lnam?>" placeholder="languagename" required />
		<button name="cmd" value="rename_language" type="submit">Change it!</button>
  	</fieldset>
</form>
</p>
	

</body>
</html>