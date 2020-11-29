<?php include_once('connect-to-db.php'); ?>
<?php include_once('posting.php'); ?>
<?php
set_time_limit(0);
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

$added_posts = 0;
if($posts) {
    foreach ($posts as $post){
        deleteSavedAttachments();
        $post_text = getReplacedPostText($post['text']);
        $post_attachments = getSavedAttachments($post['attachments']);
        $posting->addPost($group_id_for_posting, $post_text, $post_attachments, $time_for_post->getTimestamp());
        $time_for_post->add(new DateInterval('PT' . $period_posts . 'M'));
        $added_posts++;
    }
    $conn->close();
    header("Location: /index.php?Added_Posts=".$added_posts."&group_id_for_posting=".$group_id_for_posting."&group_id_for_get_post=".$group_id_for_get_post."&count=".$count."&offset=".$offset."&photos_in_post=".$photos_in_post."&comments=".$comments."&likes=".$likes."&reposts=".$reposts."&views=".$views."&count_text=".$count_text."&period_posts=".$period_posts."&start_time_for_post=".$start_time_for_post);
} else{
    $conn->close();
    die("За такими параметрами немає постів");
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
    $letters = array('М' => 'M','В' => 'B','Н' => 'H','К' => 'K','Т' => 'T','р' => 'p', 'е' => 'e','а' => 'a', 'х' => 'x' ,'у' => 'y' , 'о' => 'o', 'с' => 'c');
    foreach ($letters as $russian_letter => $english_letter){
        $post_text = str_replace($russian_letter, $english_letter, $post_text);
    }
    $arrayOfStrings = ["Что скажете?", "Что думаете?", "Ваше мнение?", "Как считаете?", "Дааа уж", "Есть что сказать об этом?"];
    $randomInt = random_int(0, (count($arrayOfStrings) - 1));
    $post_text .= "\n" . $arrayOfStrings[$randomInt];
    return $post_text;
}


function getFirstAccessKey($conn){
    $sql = "SELECT access_tokens FROM Access_Tokens";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $access_token = $row['access_tokens'];
    return $access_token;
}