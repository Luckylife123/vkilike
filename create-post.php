<?php include_once('connect-to-db.php'); ?>
<?php include_once('posting.php'); ?>
<?php
$post_id = $_GET['post-id'];
$sql = "Select * FROM Posts WHERE id = '".$post_id."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
   $access_token = getFirstAccessKey($conn);
   $row = $result->fetch_assoc();
   $vk_group_id = $row['vk_group_id'];
   $post_text = $row['post_text'];
   die($vk_group_id);
   $posting = new Posting($access_token);
   $posting->addPost($vk_group_id,$post_text);
   header("Location: /group-page.php?vk-group-id=".$vk_group_id);
   $conn->close();
   exit();

} else{
    $conn->close();
    die('error mysql not found row');
}

$conn->close();



function getFirstAccessKey($conn){
    $sql = "SELECT access_tokens FROM Access_Tokens";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $access_token = $row['access_tokens'];
    return $access_token;
}

