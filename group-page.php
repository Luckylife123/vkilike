<?php include_once ('header.php')?>
<?php include_once('connect-to-db.php'); ?>
<?php
$sql = "SELECT id, post_text, post_imgages FROM Posts WHERE vk_group_id = ".$_GET['vk_group_id'];
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()):?>
        <div style="padding: 10px 0">
            <div>
                <?php echo $row['post_text'];?>
            </div>
            <div>
                <?php echo $row['post_imgages'];?>
            </div>
        </div>

    <?php endwhile;
}
$conn->close();
?>
<?php include_once ('footer.php')?>
