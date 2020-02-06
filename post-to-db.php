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
        $post_attachments = $post['attachments'];
        addPostToDb($conn,$vk_group_id,$post_text,$post_attachments);
    }
    header("Location: /index.php");
    $conn->close();
    exit();
} else{
    die("nema postiv");
    $conn->close();
}



function addPostToDb($conn,$vk_group_id,$post_text,$post_attachments){
    $time_for_post = getTimeForPost($vk_group_id, $conn);
    $pathId = getPathId($conn);
    $imagesPaths = saveImages($post_attachments, $pathId);
    if(empty($imagesPaths)){
        die('error images paths');
    }
    $post_attachments_paths = json_encode($imagesPaths);
    $post_text = getReplacedPostText($post_text);
    $sql = "INSERT INTO Posts (vk_group_id, post_text, post_images, time_for_post) VALUES ('"
        . $vk_group_id
        . "','"
        . $post_text
        . "','"
        . $post_attachments_paths
        . "','"
        . $time_for_post . "')";
    if ($conn->query($sql) != true) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->close();
    }
}






?>