<?php include_once('connect-to-db.php'); ?>
<?php include_once('posting.php'); ?>
<?php
$sql = "SELECT access_tokens FROM Access_Tokens";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$access_token = $row['access_tokens'];


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
if($posts){
    foreach ($posts as $post){
        $sql = "INSERT INTO Posts (vk_group_id, post_text, post_photos) VALUES ('"
            . $vk_group_id
            . "','"
            . $post['text']
            . "','"
            . $post['text'] . "')";
        if ($conn->query($sql) === true) {
            $added = true;
        }

    }
    if ($added) {
        $conn->close();
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
    }
}
else{
    die("nema postiv");
    $conn->close();
}



?>