<?php
require_once __DIR__ . '/vendor/autoload.php';

use VK\Client\VKApiClient;

class Posting
{
    const MARKED_AS_ADS = 1;

    const POST_TYPE = 'post';

    const ATTACHMENT_TYPE = 'photo';

    private $access_token;

    private $vkApiClient;

    function __construct($access_token)
    {
        $this->vkApiClient = new VKApiClient();
        $this->access_token = $access_token;
    }

    public function addPost($groupId, $text, $attachments)
    {
        $upload_url = $this->getUploadServer($groupId);
        if(isset($upload_url)){
            die('upload server not found');
        }
        $attachments = json_decode($attachments);
        $attachments_codes = $this->uploadToVk($attachments, $upload_url);
        die($attachments_codes);
        $result = $this->vkApiClient->wall()->post($this->access_token, [
            'owner_id' => '-' . $groupId,
            'message' => $text,
        ]);
        return $result;
    }

    public function uploadToVk($attachments,$upload_url){
        $attachments_codes = [];
        $vkRequest = $this->vkApiClient->getRequest();
        foreach ($attachments as $attachment){
            array_push($attachments_codes, json_decode($vkRequest->post($upload_url,[
                'photo' => $attachment
            ])));
        }
        return $attachments_codes;
    }

    public function getUploadServer($groupId){
        $result = $this->vkApiClient->photos()->getWallUploadServer($this->access_token,[
            'group_id' => $groupId
        ]);
        $upload_url = $result['upload_url'];
        return $upload_url;
    }

    public function getFilteredPosts(
        $groupId,
        $count = 1,
        $offset = 0,
        $photos_in_post = 0,
        $comments = 0,
        $likes = 0,
        $reposts = 0,
        $views = 0
    ) {
        $posts = $this->vkApiClient->wall()->get($this->access_token, [
            'owner_id' => '-' . $groupId,
            'count' => $count,
            'offset' => $offset,
        ]);
        if(empty($posts)){
            return false;
        }
        $posts = $posts['items'];
        $validatePosts = [];
        foreach ($posts as $post) {
            $isValidatePost = $this->filterPost($post, $photos_in_post, $comments, $likes, $reposts, $views);
            if ($isValidatePost) {
                array_push($validatePosts, $post);
            }
        }
        if (empty($validatePosts)) {
            return false;
        } else {
            return $validatePosts;
        }
    }

    public function filterPost($post, $photos_in_post, $comments, $likes, $reposts, $views)
    {
        if ($this->isMarkedAds($post)) {
            return false;
        }
        if ($this->isHasLessPhotos($post, $photos_in_post)) {
            return false;
        }
        if ($this->isHasLessActivity($post['comments']['count'], $comments)) {
            return false;
        }
        if ($this->isHasLessActivity($post['likes']['count'], $likes)) {
            return false;
        }
        if ($this->isHasLessActivity($post['reposts']['count'], $reposts)) {
            return false;
        }

        if ($this->isHasLessActivity($post['views']['count'], $views)){
            return false;
        }

        return true;
    }

    public function isHasLessActivity($activity, $minActivity)
    {
        if(!isset($activity)){
            $activity = 0;
        }
        if ($activity >= $minActivity) {
            return false;
        } else {
            return true;
        }
    }

    public function isMarkedAds($post)
    {
        if ($post['marked_as_ads'] == Posting::MARKED_AS_ADS) {
            return true;
        } else {
            return false;
        }
    }

    public function isHasLessPhotos($post, $photos_in_post)
    {
        $count_photos = 0;
        $postAttachments = $post['attachments'];
        if (!empty($postAttachments)) {
            foreach ($postAttachments as $attachment) {
                if ($attachment['type'] == Posting::ATTACHMENT_TYPE) {
                    $count_photos++;
                }
            }
        }
        if ($count_photos >= $photos_in_post) {
            return false;
        } else {
            return true;
        }
    }


}