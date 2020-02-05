<?php include_once('connect-to-db.php'); ?>
<?php include_once('posting.php'); ?>
<?php
$now = new DateTime();
$access_token = getFirstAccessKey($conn);
$post_time = $now->format('Y-m-d H:i:s');
$sql = "Select * FROM Posts WHERE is_posted = '0' AND time_for_post <= '". $post_time."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $time_for_post = $row['time_for_post'];
        $vk_group_id = $row['vk_group_id'];
        $post_id = $row['id'];
        $post_text = $row['post_text'];
        $post_attachments = $row['post_images'];
        $group_code = getGroupCode($conn, $vk_group_id);
        $posting = new Posting($access_token);
        $posting->addPost($group_code, $post_text, $post_attachments);
        posted($conn, $post_id);

    }
}
$conn->close();

function getFirstAccessKey($conn)
{
    $sql = "SELECT access_tokens FROM Access_Tokens";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $access_token = $row['access_tokens'];

    return $access_token;
}

function posted($conn, $post_id){
    $sql = "UPDATE Posts SET is_posted = '1' WHERE id = '".$post_id."'";
    $conn->query($sql);
}

function getGroupCode($conn, $vk_group_id)
{
    $sql = "Select * FROM Vk_Groups WHERE id = '" . $vk_group_id . "'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    return $row['group_code'];
}
