<?php
namespace App\Model;

use Cake\Core\Configure;

class Blog {
    public $pageSize;
    public $posts;
    public $apiKey;
    public $blogName;
    public $numPosts;

    public function __construct($blogName) {
        $this->apiKey = Configure::read('tumblr_api');
        $this->pageSize = Configure::read('page_size');
        $this->blogName = $blogName;
        $this->numPosts = $this->numPosts();
    }

    //Load the next <n> posts starting at $offset
    public function loadPostsRange($offset=0) {
        $apiKey = Configure::read('tumblr_api');
        $url = "http://api.tumblr.com/v2/blog/{$this->blogName}/posts/?limit={$this->pageSize}&offset=$offset";
        $data = $this->tumblrApiCall($this->blogName, $url);

        if($data && $data['response'] && $data['response']['posts']) {
            $posts = $data['response']['posts'];
        }else {
            //Error parsing json
            $posts = array();
        }

        return $posts;
    }

    //Returns the total number of posts for the blog
    private function numPosts() {
        $url = "http://api.tumblr.com/v2/blog/{$this->blogName}/info/?";
        $data = $this->tumblrApiCall($this->blogName, $url);

        if($data && $data['response'] && $data['response']['blog']) {
            return $data['response']['blog']['posts'];
        }else {
            return -1;
        }
    }

    //Loads all posts for the blog at once. This doesn't get used because it's slow for large blogs.
    private function loadAllPosts() {
        $this->posts = array();
        $numPosts = $this->numPosts;
        if($numPosts <=0) {
            //No posts or an error occurred
            throw new Exception("Unable to find the number of posts. Please verify that this blog contains content.");
        }

        $start = 0;
        $offset = $this->pageSize;
        do {
            if($offset > $numPosts) {
                $offset = $numPosts-1;
            } 

            $posts = $this->loadPostsRange($this->blogName, $start);
            $this->posts = array_merge($this->posts, $posts);

            $start = $offset+1;
            $offset += $this->pageSize;
        } while($offset <= $numPosts);


        if(count($this->posts) > 0) {
            echo '<pre>' . print_r($this->posts, true) . '</pre>';
        }else {
            //Error parsing json
            //echo '<pre>' . print_r($rawdata, true) . '</pre>';
            throw new Exception("Unable to load all posts");
        }

        return true;
    }

    //Generic function to call the Tumblr API
    private function tumblrApiCall($blogName, $url) {
        $url .= "&api_key={$this->apiKey}";

        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_HEADER=> false,
            CURLOPT_RETURNTRANSFER=> true
        ));
        $rawdata = curl_exec($ch);

        $data = json_decode($rawdata, true);

        curl_close($ch);

        return $data;
    }



}
?>
