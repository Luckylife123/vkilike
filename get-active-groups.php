<?php include_once('connect-to-db.php'); ?>
<?php
$sql = "SELECT id, group_code, group_name FROM Vk_Groups";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()):?>
		<div style="padding: 10px;border: 1px solid #000;">
            <span>
                    <?php echo $row['group_name']; ?>
            </span>
			<form action="/group-page.php" method="get">
				<input type="text" name="vk-group-id" hidden value="<?php echo $row['id']; ?>">
				<button type="submit">Відкрити пости</button>
			</form>
			<form action="/post-to-db.php" method="get">
				<input type="text" name="vk-group-id" hidden value="<?php echo $row['id']; ?>">
				<input type="text" name="groupId" placeholder="groupId" required>
				<input type="text" name="count" placeholder="count" required>
				<input type="text" name="offset" placeholder="offset" required>
				<input type="text" name="photos_in_post" placeholder="photos in post" required>
				<input type="text" name="comments" placeholder="comments in post" required>
				<input type="text" name="likes" placeholder="likes in post" required>
				<input type="text" name="reposts" placeholder="reposts in post" required>
				<input type="text" name="views" placeholder="views in post" required>
				<button type="submit">Добавити пости</button>
			</form>
		</div>
    <?php endwhile;
}
$conn->close();
?>


