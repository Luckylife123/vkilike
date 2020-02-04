<?php include_once('connect-to-db.php'); ?>
<?php

$post_id = $_GET['post-id'];
$vk_group_id = $_GET['vk-group-id'];
$sql = "DELETE FROM Posts WHERE id = '".$post_id."'";

if ($conn->query($sql) === true) {
    header("Location: /group-page.php?vk-group-id=".$vk_group_id);
    $conn->close();
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
}

?>