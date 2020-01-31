<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

</head>
<body>
<?php
require_once __DIR__ . '/vendor/autoload.php';




$oauth = new VK\OAuth\VKOAuth();
$client_id = 7302376;
$redirect_uri = 'http://vk-posts.tmweb.ru/';
$display = VK\OAuth\VKOAuthDisplay::PAGE;
$scope = [VK\OAuth\Scopes\VKOAuthUserScope::WALL, VK\OAuth\Scopes\VKOAuthUserScope::GROUPS, VK\OAuth\Scopes\VKOAuthUserScope::OFFLINE];
$state = '';
$browser_url = $oauth->getAuthorizeUrl(VK\OAuth\VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);
echo '<a href="' . $browser_url . '"/>Url auth</a>';
if($_GET['code']){
    $code = $_GET['code'];
    $client_secret = 'XDQY2tbz2dLSWigCI4FA';
    $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
    $access_token = $response['access_token'];
    print_r($response);
    echo $access_token;
}
$vk = new VK\Client\VKApiClient();
$response = $vk->wall()->post($access_token, array(
    'owner_id' => '27162548',
	'message' => 'test'
));
print_r($response);
echo $response;
echo "test";
?>


</body>
</html>