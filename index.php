<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

</head>
<body>
<?php
$access_token = 'd27d9dbb141037e4ff9053415240dc3e96a2cc2c28f95b1e865677634391800bbb4c76376e543de7ef44a';
$vk = new VK\Client\VKApiClient();
$respons = $vk->wall()->post($access_token,array(
		'owner_id' => '27162548',
		'message'  => 'test',
	));
print_r($respons);
?>
</body>
</html>