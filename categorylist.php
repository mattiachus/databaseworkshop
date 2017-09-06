<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>

<?php

if($cmd = filter_input(INPUT_POST, 'cmd')){
	
	if($cmd == 'add_category'){
		// code to add a new category
		
		$cnam = filter_input(INPUT_POST, 'categoryname')
			or die('Missing/illegal categroyname parameter');
		
		require_once('dbcon.php');
		$sql = 'INSERT INTO category (name) VALUES (?)';
		$stmt = $link->prepare($sql);
		$stmt->bind_param('s', $cnam);
		$stmt->execute();
		
		if($stmt->affected_rows > 0){
			echo 'Category "'.$cnam.'" added';
		}
		else{
			echo 'Could not add the category';
		}		
	}
    elseif($cmd == 'delete_category'){
		// code to delete the category
		
		$cid = filter_input(INPUT_POST, 'categoryid', FILTER_VALIDATE_INT)
			or die('Missing/illegal categoryid parameter');
		
		require_once('dbcon.php');
		$sql = 'DELETE FROM category WHERE category_id=?';
		$stmt = $link->prepare($sql);
		$stmt->bind_param('i', $cid);
		$stmt->execute();
		
		if($stmt->affected_rows > 0){
			echo 'Category "'.$cid.'" deleted';
		}
		else{
			echo 'Could not delete category '.$cid;
		}			
		
	}
	else {
		die('Unknown cmd parameter');
	}
}
    ?>
 
	<h1>Categories</h1>
	<ul>
<?php
		require_once('dbcon.php');
		$sql = 'SELECT category_id, name FROM category';
		$stmt = $link->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($cid, $nam);
		while($stmt->fetch()){ ?>
		
		<li>
			<a href="filmlist.php?categoryid=<?=$cid?>"><?=$nam?></a>
			<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
				<input type="hidden" name="categoryid" value="<?=$cid?>" />
				<button type="submit" name="cmd" value="delete_category">Delete</button>
			</form>
			<a href="renamecategory.php?categoryid=<?=$cid?>">Rename</a>
		</li>

<?php	} ?>
	</ul>
<hr>


<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<fieldset>
    	<legend>Add new category</legend>
    	<input name="categoryname" type="text" placeholder="Categoryname" required />
		<button name="cmd" value="add_category" type="submit">Create it!!!</button>
  	</fieldset>
</form>

<a href="form.php"> Add a new actor</a>    
  
    

</body>
</html>