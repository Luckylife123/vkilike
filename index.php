<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

</head>
<body>
<?php
$group_id = "-176950270";
$token = '55793f142a35b289949f684006a1972e9948a708570b01dbcb5c090d179adb272a2c86186f85a8e6ececd';
$text = 'test';


$url = printf('https://api.vk.com/method/wall.post?');
$ch = curl_init();
curl_setopt_array($ch, array(
	CURL_POST => TRUE,
	CURLOPT_RETURNTRANSFER => TRUE,
	CURLOPT_SSL_VERIFYPEER => FALSE,
	CURLOPT_SSL_VERIFYHOST => FALSE,
	CURLOPT_POSTFIELDS     => array(
		"owner_id"     => $group_id,
		"from_group"   => 1,
		"Message"      => $text,
		"access_token" => $token
	),
	CURLOPT_URL => $url,
));
$query = curl_exec($ch);
$curl_error_code = curl_errno($curl);
$curl_error = curl_error($curl);

$http_status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
curl_close($ch);
echo $curl_error_code;
?>
</body>
</html>