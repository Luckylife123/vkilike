<?php include_once ('header.php')?>
<?php include_once('get-active-groups.php'); ?>

<form action="/add-group.php" method="get">
	<input type="text" name="group_code" placeholder="group_code" required>
	<input type="text" name="group_name" placeholder="group_name" required>
	<input type="text" name="time_for_post" placeholder="time_for_post" required>
	<button type="submit">
		Добавити групу
	</button>
</form>
<?php
$date = new DateTime('2020-02-06 18:01');
$date->getTimestamp()
?>
<?php include_once ('footer.php')?>
