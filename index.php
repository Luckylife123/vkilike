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
echo 'test';
$posting = new Posting($access_token);
echo 'test2';
$posts = $posting->getPosts('123302199');
$getText = $posting->addToPosting($posts);
$posting->addPost('176950270', $getText);


fasdfadsf

?>
</body>
</html>