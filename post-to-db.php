<?php include_once('connect-to-db.php'); ?>
<?php include_once('posting.php'); ?>
<?php

$access_token = getFirstAccessKey($conn);

$vk_group_id = $_GET['vk-group-id'];
$groupId = $_GET['groupId'];
$count = $_GET['count'];
$offset = $_GET['offset'];
$photos_in_post = $_GET['photos_in_post'];
$comments = $_GET['comments'];
$likes = $_GET['likes'];
$reposts = $_GET['reposts'];
$views = $_GET['views'];


$posting = new Posting($access_token);
$posts = $posting->getFilteredPosts($groupId, $count,$offset,$photos_in_post,$comments,$likes,$reposts,$views);
$added = false;

if($posts) {
    foreach ($posts as $post){
        $post_text = $post['text'];
        $post_attachments = $post['text'];
        addPostToDb($conn,$vk_group_id,$post_text,$post_attachments);
    }
} else{
    die("nema postiv");
    $conn->close();
}


function addPostToDb($conn,$vk_group_id,$post_text,$post_attachments){
    $time_for_post = getTimeForPost($vk_group_id, $conn);
    $sql = "INSERT INTO Posts (vk_group_id, post_text, post_images, time_for_post) VALUES ('"
        . $vk_group_id
        . "','"
        . $post_text
        . "','"
        . $post_attachments
        . "','"
        . $time_for_post . "')";
    if ($conn->query($sql) != true) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->close();
    }
}
function getTimeForPost($vk_group_id, $conn){
    $time_group_for_post = getGroupTimeForPost($vk_group_id, $conn);
    $sql = "SELECT time_for_post FROM Posts WHERE vk_group_id = '".$vk_group_id."' ORDER BY 'time_for_post' DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_post_time = new DateTime($row['time_for_post']);
        $last_post_time->add(new DateInterval('PT' . $time_group_for_post . 'M'));
        $post_time = $last_post_time->format('Y-m-d H:i:s');
        return $post_time;
    }
    else{
        $now = new DateTime();
        $now->add(new DateInterval('PT' . $time_group_for_post . 'M'));
        $post_time = $now->format('Y-m-d H:i:s');
        return $post_time;
    }
}


function getGroupTimeForPost($vk_group_id, $conn){
    $sql = "SELECT time_for_post FROM Vk_Groups WHERE id = '". $vk_group_id ."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['time_for_post'];
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
    }
}

function getFirstAccessKey($conn){
    $sql = "SELECT access_tokens FROM Access_Tokens";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $access_token = $row['access_tokens'];
    return $access_token;
}


?>