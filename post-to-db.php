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
function getReplacedPostText($post_text){
    $letters = array('е' => 'e','а' => 'a', 'х' => 'x' ,'у' => 'y' , 'о' => 'o');
    foreach ($letters as $russian_letter => $english_letter){
        $post_text = str_replace($russian_letter, $english_letter, $post_text);
    }
    return $post_text;
}
function saveImages($post_attachments, $pathId){
    $imagePaths = [];
    foreach ($post_attachments as $attachment){
        if($attachment['type'] == 'photo'){
            $max_width = 0;
            $imageUrl = "";
            foreach ($attachment['photo']['sizes'] as $size){
                if($max_width < $size['width']){
                    $imageUrl = $size['url'];
                    $imageName = basename($imageUrl);
                }
            }
            $imgPath = 'images/posts/post'.$pathId;
            if (!file_exists($imgPath)) {
                mkdir($imgPath, 0777, true);
            }
            $imgPath .= '/'.$imageName;
            if(!file_put_contents($imgPath, file_get_contents($imageUrl))){
                return false;
            }else{
                array_push($imagePaths, $imgPath);
            }
        }
    }
    return $imagePaths;
}

function getPathId($conn){
    $sql = "SHOW TABLE STATUS LIKE 'Posts'";
    $result= $conn->query($sql);
    if(!$result){
        $pathId =  1;
    }
    else{
        $row = $result->fetch_assoc();
        $pathId = $row['Auto_increment'];
    }
    return $pathId;
}

function getTimeForPost($vk_group_id, $conn){
    $time_group_for_post = getGroupTimeForPost($vk_group_id, $conn);
    $sql = "SELECT time_for_post FROM Posts WHERE vk_group_id = '".$vk_group_id."' ORDER BY time_for_post DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_post_time = new DateTime($row['time_for_post']);
        $last_post_time->add(new DateInterval('PT' . $time_group_for_post . 'M'));
        $post_time = $last_post_time->format('Y-m-d H:i:s');
        return $post_time;
    }
    else{
        $now = new DateTime('now',new DateTimeZone('Europe/Kiev'));
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