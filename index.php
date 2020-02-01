<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

</head>
<body>
<?php
$access_token = 'd64bc24c383c5ea517ec9c74b9ba6f94c46ade0c3554ddfb6f532bf6159f4aaf4f462c1585edcf5782c9a';
$vk = new VK\Client\VKApiClient();
$respons = $vk->wall()->post($access_token,array(
		'owner_id' => '27162548',
		'message'  => 'test'
	));
print_r($respons);
?>
</body>
</html>