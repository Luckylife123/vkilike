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

    public function addPost($groupId, $text, $attachments, $time_for_post)
    {
        $upload_url = $this->getUploadServer($groupId);
        if (!isset($upload_url)) {
            die('upload server not found');
        }
        $attachments_codes = $this->uploadToVk(json_decode($attachments), $upload_url);
        $loaded_photos = $this->saveWallPost($attachments_codes, $groupId);
        $photos = $this->getPhotosFromVk($loaded_photos);
        $result = $this->vkApiClient->wall()->post($this->access_token, [
            'owner_id' => '-' . $groupId,
            'message' => $text,
            'attachments' => $photos,
            'from_group' => 1,
            'publish_date' => $time_for_post,
        ]);

        return $result;
    }

    public function getPhotosFromVk($loaded_photos)
    {
        $photos = "";
        foreach ($loaded_photos as $photo) {
            $photos .= "photo" . $photo[0]['owner_id'] . "_" . $photo[0]['id'] . ",";
        }

        return $photos;
    }

    public function saveWallPost($attachments_codes, $group_id)
    {
        $loaded_photos = [];
        foreach ($attachments_codes as $attachment_code) {
            $result = $this->vkApiClient->photos()->saveWallPhoto($this->access_token, [
                "group_id" => $group_id,
                "photo" => $attachment_code['photo'],
                "server" => $attachment_code['server'],
                "hash" => $attachment_code['hash'],
            ]);
            array_push($loaded_photos, $result);
        }

        return $loaded_photos;
    }

    public function uploadToVk($attachments, $upload_url)
    {
        $attachments_codes = [];
        foreach ($attachments as $attachment) {
            print_r($attachment);
            die('tset');
            array_push($attachments_codes, $this->vkApiClient->getRequest()
                ->upload($upload_url, 'photo', 'http://vk-posts.tmweb.ru/'.$attachment));
        }

        return $attachments_codes;
    }

    public function getUploadServer($groupId)
    {
        $result = $this->vkApiClient->photos()->getWallUploadServer($this->access_token, [
            'group_id' => $groupId,
        ]);
        $upload_url = $result['upload_url'];

        return $upload_url;
    }

    public function getFilteredPosts(
        $groupId,
        $count,
        $offset,
        $photos_in_post,
        $comments,
        $likes,
        $reposts,
        $views,
        $count_text
    ) {
        $posts = $this->vkApiClient->wall()->get($this->access_token, [
            'owner_id' => '-' . $groupId,
            'count' => $count,
            'offset' => $offset,
        ]);
        if (empty($posts)) {
            return false;
        }
        $posts = $posts['items'];
        $validatePosts = [];
        foreach ($posts as $post) {
            $isValidatePost = $this->filterPost($post, $photos_in_post, $comments, $likes, $reposts, $views, $count_text);
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

    public function filterPost($post, $photos_in_post, $comments, $likes, $reposts, $views, $count_text)
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
        if ($this->isHasLessActivity($post['views']['count'], $views)) {
            return false;
        }
        if ($this->isHasLessText($post['text'], $count_text)) {
            return false;
        }

        return true;
    }


    public  function isHasLessText($post_text, $count_text){
        if($count_text > iconv_strlen($post_text, 'UTF-8')){
            return true;
        }
        else{
            return false;
        }
    }
    public function isHasLessActivity($activity, $minActivity)
    {
        if (!isset($activity)) {
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