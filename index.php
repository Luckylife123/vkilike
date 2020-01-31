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

session_start();
if(!$_SESSION['access_token']){
    $oauth = new VK\OAuth\VKOAuth();
    $client_id = 7302376;
    $redirect_uri = 'http://vk-posts.tmweb.ru/';
    $display = VK\OAuth\VKOAuthDisplay::PAGE;
    $scope = array(VK\OAuth\Scopes\VKOAuthUserScope::WALL, VK\OAuth\Scopes\VKOAuthUserScope::GROUPS);
    $state = '';
    $browser_url = $oauth->getAuthorizeUrl(VK\OAuth\VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);
    if(!$_GET['code']){
        echo  '<a href="'.$browser_url.'"/>Url auth</a>';
    }
    else{
        $code = $_GET['code'];
        $client_secret = 'XDQY2tbz2dLSWigCI4FA';
        $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
        $access_token = $response['access_token'];
        if($access_token){
            $_SESSION['access_token'] = $access_token;
            echo $_SESSION['access_token'];
        }
    }
}else{
    echo $_SESSION['access_token'];
}

?>



</body>
</html>