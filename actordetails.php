<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

<?php 
	$fid = filter_input(INPUT_GET, 'actorid', FILTER_VALIDATE_INT)
		or die('Missing/illegal Actor ID parameter')
?>
	
<h2>ACTOR</h2>

<?php
	require_once('dbcon.php');
	$sql = 'SELECT actor_id, first_name, last_name FROM actor where actor_id=?';
	$stmt = $link->prepare($sql);
	$stmt->bind_param('i', $fid);
	$stmt->execute();
	$stmt->bind_result($aid, $firstname, $lastname);
	while($stmt->fetch()){ ?>
<h1><?=$title?></h1>
    <ul>
		<li><a>First name: <?=$firstname?></a></li> 
        <li><a>Last name: <?=$lastname?></a></li>  
    </ul>  
		
<?php } ?>
<h2>FILMS</h2>
<?php
$sql = 'SELECT  film.film_id, film.title
					from  film, actor, film_actor
					WHERE film_actor.actor_id = actor.actor_id
					AND film_actor.film_id = film.film_id
					AND actor.actor_id = ?';
		require_once('dbcon.php');
$stmt = $link->prepare($sql);
	$stmt->bind_param('i', $fid);
	$stmt->execute();
	$stmt->bind_result($fid, $ftitle);
	while($stmt->fetch()){ ?>
		
		<li><a href="filmdetails.php?filmid=<?=$fid?>"><?=$ftitle?></a></li>

<?php } ?>

</body>
</html>