<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

</head>
<body>
<?php
//get access token https://oauth.vk.com/authorize?client_id=7302576&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=wall,offline,groups&response_type=token&v=5.103
$access_token = 'd64bc24c383c5ea517ec9c74b9ba6f94c46ade0c3554ddfb6f532bf6159f4aaf4f462c1585edcf5782c9a';
include('posting.php');
$posting = new Posting($access_token);
$posts = $posting->getFilteredPosts('123302199',2,0,0,3,0,0,0);
$i = 0;
foreach ($posts as $post){
	$i++;
    $posting->addPost('176950270', $post['text']);
}
echo $i;
?>
</body>
</html>