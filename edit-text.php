<?php include_once('connect-to-db.php'); ?>
<?php

$vk_group_id = $_GET['vk-group-id'];
$post_id = $_GET['post-id'];
$post_text = $_GET['post-text'];
$sql = "UPDATE Posts SET post_text='".$post_text."' WHERE id = '".$post_id."'";

if ($conn->query($sql) === true) {
    header("Location: /group-page.php?vk-group-id=".$vk_group_id);
    $conn->close();
    exit();

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
}

?>