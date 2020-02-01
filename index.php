<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

</head>
<body>
<?php
require_once __DIR__.'/vendor/autoload.php';

$vk = new VK\Client\VKApiClient();

//get access token https://oauth.vk.com/authorize?client_id=7302576&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=wall,offline,groups&response_type=token&v=5.103
$access_token = 'd64bc24c383c5ea517ec9c74b9ba6f94c46ade0c3554ddfb6f532bf6159f4aaf4f462c1585edcf5782c9a';

//$response = $vk->wall()->post($access_token,array(
//    'owner_id' => '27162548',
//    'message'  => 'test'
//));

$response = $vk->wall()->get($access_token, array(
		'owner_id' => '176950270',
		'count'    => 1
));
print_r($response);
?>
</body>
</html>