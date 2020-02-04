<?php include_once ('header.php')?>
<?php include_once('connect-to-db.php'); ?>
<?php

$vk_group_id = $_GET['vk-group-id'];
$sql = "SELECT id, post_text, post_images FROM Posts WHERE vk_group_id = '" . $vk_group_id ."' AND is_posted = '0'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()):?>
        <div style="padding: 10px 0;border: 1px solid #000;">
            <div>
	            <form action="edit-text.php" method="get">
		            <input type="text" name="vk-group-id" value="<?php echo $vk_group_id?>" hidden>
		            <input type="text" name="post-id" value="<?php echo $row['id']?>" hidden>
		            <textarea name="post-text" cols="30" rows="10">
			            <?php echo $row['post_text'];?>
		            </textarea>
		            <button type="submit">Зберегти текст</button>
	            </form>
            </div>
            <div>
                <?php echo $row['post_images'];?>
            </div>
	        <div>
		        <form action="edit-time.php" method="get">
			        <input type="text" name="vk-group-id" value="<?php echo $vk_group_id?>" hidden>
			        <input type="text" name="post-id" value="<?php echo $row['id']?>" hidden>
			        <input name="post-time" value="<?php echo $row['time_for_post'];?>">
			        <button type="submit">Зберегти час</button>
		        </form>
	        </div>
	        <form action="delete-post.php" method="get">
		        <input type="text" name="post-id" hidden value="<?php echo $row['id']; ?>">
		        <button type="submit">Видалити пост</button>
	        </form>
        </div>

    <?php endwhile;
}
$conn->close();
?>
<?php include_once ('footer.php')?>
