<?php include_once('connect-to-db.php'); ?>
<?php include_once('posting.php'); ?>
<?php
$access_token = getFirstAccessKey($conn);

$group_id_for_delete_posts = $_GET['group_id_for_delete_posts'];
$count = $_GET['count'];
$offset = $_GET['offset'];

$posting = new Posting($access_token);
$posts = $posting->getPosts($group_id_for_delete_posts, $count, $offset);
$post_views_count = 0;

if($posts) {
    foreach ($posts as $key => $post){
        if($post_views_count > $post['views']['count']){
            $post_views_count = $post['views']['count'];
        }
    }
    foreach ($posts as $post){
        if($post_views_count = $post['views']['count']){
            unset($posts[$key]);
        }
    }


    $post_views_count = 0;
    foreach ($posts as $key => $post){
        if($post_views_count > $post['views']['count']){
            $post_views_count = $post['views']['count'];
        }
    }
    foreach ($posts as $key => $post){
        print_r($post);
        die("Tset");

        if($post_views_count = $post['views']['count']){
            unset($posts[$key]);
        }
    }

    foreach ($posts as $key => $post){
        $posting->deletePost($group_id_for_delete_posts, $post['id']);
    }

    $conn->close();
}




function getFirstAccessKey($conn){
    $sql = "SELECT access_tokens FROM Access_Tokens";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $access_token = $row['access_tokens'];
    return $access_token;
}