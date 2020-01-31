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


$vk = new  VK\Client\VKApiClient();

$oauth = new VK\OAuth\VKOAuth();
$client_id = 7302376;
$redirect_uri = 'http://vk-posts.tmweb.ru/';
$display = VK\OAuth\VKOAuthDisplay::PAGE;
$scope = array(VK\OAuth\Scopes\VKOAuthUserScope::WALL, VK\OAuth\Scopes\VKOAuthUserScope::GROUPS);
$state = '';
$browser_url = $oauth->getAuthorizeUrl(VK\OAuth\VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);
echo  '<a href="'.$browser_url.'"/>Url auth</a>';
$code = $_GET['code'];
if($code){
    $client_secret = 'XDQY2tbz2dLSWigCI4FA';
    $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
    print_r($response);
    $access_token = $response['access_token'];
    die($access_token);
}

?>



</body>
</html>