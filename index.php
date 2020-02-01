<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

</head>
<body>
<?php
$access_token = 'b78a3c763183ee74dc4b53e190236f9d80f3c4e12e1cc52449fdd980fca726adafd566241f0411033a748';
$vk = new VK\Client\VKApiClient();
$respons = $vk->wall()->post($access_token,array(
		'owner_id' => '27162548',
		'message'  => 'test',
	));
print_r($respons);
?>
</body>
</html>