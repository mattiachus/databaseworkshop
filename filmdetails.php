<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>

<?php 
	$fid = filter_input(INPUT_GET, 'filmid', FILTER_VALIDATE_INT)
		or die('Missing/illegal filmID parameter')
?>
	


<?php
	require_once('dbcon.php');
	$sql = 'SELECT film_id, description, release_year, title, rental_rate, length, rating  FROM film where film_id=?';
	$stmt = $link->prepare($sql);
	$stmt->bind_param('i', $fid);
	$stmt->execute();
	$stmt->bind_result($filmid, $description, $relyear, $title, $rentrate, $length, $rating);
	while($stmt->fetch()){ ?>
<h1><?=$title?></h1>
    <ul>
		<li><a>Description: <?=$description?></a></li> 
        <li><a>Released: <?=$relyear?></a></li> 
        <li><a>Rental rate: <?=$rentrate?></a></li> 
        <li><a>Length: <?=$length?></a></li> 
        <li><a>Rating: <?=$rating?></a></li> 
    </ul>  
		
<?php } ?>

<h2>Categories</h2>
<?php
$sql = 'SELECT c.category_id, c.name
FROM film_category fc, category c
WHERE fc.film_id=?
AND fc.category_id = c.category_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $fid);
$stmt->execute();
$stmt->bind_result($cid, $cname);
while($stmt->fetch()) {
	echo '<li><a href="filmlist.php?cid='.$cid.'">'.$cname.'</a></li>'.PHP_EOL;
}
?>

<h2>Actors</h2>
<?php
$sql = 'SELECT a.actor_id, a.first_name, a.last_name
FROM film_actor fa, actor a
WHERE fa.film_id=?
AND fa.actor_id=a.actor_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $fid);
$stmt->execute();
$stmt->bind_result($aid, $afname, $alname);
while($stmt->fetch()) {
	echo '<li><a href="actordetails.php?actorid='.$aid.'">'.$afname.' '.$alname.'</a></li>'.PHP_EOL;
}
?>

 


</body>
</html>