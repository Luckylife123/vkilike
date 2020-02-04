<?php include_once('connect-to-db.php'); ?>
<?php

$vk_group_id = $_GET['vk-group-id'];
$post_id = $_GET['post-id'];
$post_time = $_GET['post-time'];
$sql = "UPDATE Posts SET time_for_post='".$post_time."' WHERE id = '".$post_id."'";

if ($conn->query($sql) === true) {
    header("Location: /group-page.php?vk-group-id=".$vk_group_id);
    $conn->close();
    exit();

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
}

?>