<?php
require_once __DIR__.'/vendor/autoload.php';
use VK\Client\VKApiClient;


class Posting {

    private $access_token;
    private $vkApiClient;

    function __construct($access_token){
        $this->vkApiClient = new VKApiClient();
        $this->access_token = $access_token;
    }



    public function addPost($groupId, $text){
        $result = $this->vkApiClient->wall()->post($this->access_token,array(
            'owner_id' => '-'.$groupId,
            'message'  => $text
        ));
    }


    public function getPosts($groupId, $count = 1, $offset = 0){
            $result = $this->vkApiClient->wall()->get($this->access_token, array(
                'owner_id' => '-'.$groupId,
                'count'    => $count,
                'offset'   => $offset
            ));
            return $result;
    }

    public function addToPosting($post){
        return $post['items'][0]['text'];
    }

}