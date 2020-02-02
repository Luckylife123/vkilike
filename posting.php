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

    public function addPost($groupId, $text)
    {
        $result = $this->vkApiClient->wall()->post($this->access_token, [
            'owner_id' => '-' . $groupId,
            'message' => $text,
        ]);
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