<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled document</title>
</head>

<body>

<?php
if($cmd = filter_input(INPUT_POST, 'cmd')){
	
if($cmd == 'add_actor'){
		// code to add a new category
		
		$fn = filter_input(INPUT_POST, 'first_name')
			or die('Missing/illegal first name parameter');
    
        $ln = filter_input(INPUT_POST, 'last_name')
			or die('Missing/illegal first name parameter');
		
        
		require_once('dbcon.php');
		$sql = 'INSERT INTO actor (first_name, last_name) VALUES (?,?)';
		$stmt = $link->prepare($sql);
		$stmt->bind_param('ss', $fn, $ln);
		$stmt->execute();
		
		if($stmt->affected_rows > 0){
			echo 'New actor "'.$fn.' '.$ln.' " added';
		}
		else{
			echo 'Could not add the actor';
		}		
	}	
 elseif($cmd == 'delete_actor'){
		
		$aid = filter_input(INPUT_POST, 'actor_id', FILTER_VALIDATE_INT)
			or die('Missing/illegal actorid parameter');
		
		require_once('dbcon.php');
		$sql = 'DELETE FROM actor WHERE actor_id=?';
		$stmt = $link->prepare($sql);
		$stmt->bind_param('i', $aid);
		$stmt->execute();
		
		if($stmt->affected_rows > 0){
			echo 'actor "'.$aid.'" deleted';
		}
		else{
			echo 'Could not delete actor '.$aid. '.' ;
		}				
	}
	else {
		die('Unknown cmd parameter');
	}
}
    ?>

    
  

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<fieldset>
    	<legend>Add new actor</legend>
    	<input name="first_name" type="text" placeholder="First Name" required />
        <input name="last_name" type="text" placeholder="Last Name" required />
		<button name="cmd" value="add_actor" type="submit">Add actor</button>
  	</fieldset>
</form> <hr>
    
 <a href="categorylist.php">BACK</a>  <hr> 

    	<h1>Actors:</h1>
	<ul>
<?php
		require_once('dbcon.php');
		$sql = 'SELECT actor_id, first_name, last_name FROM actor';
		$stmt = $link->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($aid, $fn, $ln);
		while($stmt->fetch()){ ?>
		
		<li>
			<a><?=$fn?> <?=$ln?></a>  
			<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
				<input type="hidden" name="actor_id" value="<?=$aid?>" />
				<button type="submit" name="cmd" value="delete_actor">Delete</button>
			</form>
			<a href="renameactor.php?actorid=<?=$aid?>">Rename</a>
		</li>

<?php	} ?>
	</ul>
   
</body>
</html>
