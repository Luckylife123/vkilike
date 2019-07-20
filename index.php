<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="http://vkontakte.ru/js/api/openapi.js"></script>

</head>
<body>
<?php
require_once __DIR__.'/vendor/autoload.php';

use \VK\Client\VKApiClient;
use \VK\OAuth\VKOAuth;
use \VK\OAuth\VKOAuthDisplay;
use \VK\OAuth\Scopes\VKOAuthUserScope;
use \VK\OAuth\VKOAuthResponseType;

$vk = new VKApiClient();
$vk = new VKApiClient('5.95');
$oauth = new VKOAuth();
$client_id = 7064288;
$redirect_uri = 'vklike.tmweb.ru';
$display = VKOAuthDisplay::PAGE;
$scope = array(VKOAuthUserScope::WALL, VKOAuthUserScope::GROUPS);
$state = 'secret_state_code';

$browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);
echo $browser_url;

if(isset($_GET['code'])){
    $oauth = new VKOAuth();
    $client_id = 7064288;
    $client_secret = '2QYjnWDPPGsfyh4EfRSj';
	$redirect_uri = 'vklike.tmweb.ru';
	$code = $_GET['code'];
	$response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
	$access_token = $response['access_token'];
}
?>




</body>
</html>