<?php include_once('connect-to-db.php'); ?>
<?php include_once('posting.php'); ?>
<?php
$access_token = getFirstAccessKey($conn);

$group_id_for_posting = $_GET['group_id_for_posting'];
$group_id_for_get_post = $_GET['group_id_for_get_post'];
$count = $_GET['count'];
$offset = $_GET['offset'];
$photos_in_post = $_GET['photos_in_post'];
$comments = $_GET['comments'];
$likes = $_GET['likes'];
$reposts = $_GET['reposts'];
$views = $_GET['views'];
$count_text = $_GET['count_text'];
$period_posts = $_GET['period_posts'];
$start_time_for_post = $_GET['start_time_for_post'];

$time_for_post = new DateTime($start_time_for_post, new DateTimeZone('Europe/Kiev'));

$posting = new Posting($access_token);
$posts = $posting->getFilteredPosts($group_id_for_get_post, $count, $offset,$photos_in_post,$comments,$likes,$reposts,$views,$count_text);


if($posts) {
    foreach ($posts as $post){
        deleteSavedAttachments();
        $post_text = getReplacedPostText($post['text']);
        $post_attachments = getSavedAttachments($post['attachments']);
        $posting->addPost($group_id_for_posting, $post_text, $post_attachments, $time_for_post->getTimestamp());
        $time_for_post->add(new DateInterval('PT' . $period_posts . 'M'));
    }
    header("Location: /index.php");
    $conn->close();
} else{
    die("За такими параметрами немає постів");
    $conn->close();
}

function getSavedAttachments($post_attachments){
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
            $imgPath = 'images/posts/post';
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
    print_r($imgPath);
    die($imagePaths);
    return $imagePaths;
}

function deleteSavedAttachments(){
    $dir = 'images'. DIRECTORY_SEPARATOR . 'posts'. DIRECTORY_SEPARATOR .'post';
    if(is_dir($dir)){
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
            RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }
}

function getReplacedPostText($post_text){
    $letters = array('е' => 'e','а' => 'a', 'х' => 'x' ,'у' => 'y' , 'о' => 'o');
    foreach ($letters as $russian_letter => $english_letter){
        $post_text = str_replace($russian_letter, $english_letter, $post_text);
    }
    return $post_text;
}


function getFirstAccessKey($conn){
    $sql = "SELECT access_tokens FROM Access_Tokens";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $access_token = $row['access_tokens'];
    return $access_token;
}