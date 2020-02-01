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
$client_id = 7302576;
$redirect_uri = 'vk-posts.tmweb.ru';
$display = VK\OAuth\VKOAuthDisplay::PAGE;
$scope = [VK\OAuth\Scopes\VKOAuthUserScope::WALL, VK\OAuth\Scopes\VKOAuthUserScope::GROUPS, VK\OAuth\Scopes\VKOAuthUserScope::OFFLINE];
$state = '';
//Authorization Code Flow
//$browser_url = $oauth->getAuthorizeUrl(VK\OAuth\VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);
//echo '<a href="' . $browser_url . '"/>Url auth</a>';
//if($_GET['code']){
//    $code = $_GET['code'];
//    $client_secret = 'c0XrAfeDXiPVZSqN82ay';
//    $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
//    $access_token = $response['access_token'];
//}


//Implicit flow
$browser_url = $oauth->getAuthorizeUrl(VK\OAuth\VKOAuthResponseType::TOKEN, $client_id, $redirect_uri, $display, $scope, $state, null, false);
echo '<a href="' . $browser_url . '"/>Url auth</a>';

    $access_token = 'e4b8de2b91503b17df9676b4566f3c8a4f0679ddb47454ad62a499a2bb9bca318c8db79f96beeeeaca709';

if($access_token){
	echo $access_token;
    $vk = new VK\Client\VKApiClient();
    $response = $vk->wall()->post($access_token, array(
        'owner_id' => '27162548',
        'message' => 'test',
    ));
    echo "test";
}
?>


</body>
</html>