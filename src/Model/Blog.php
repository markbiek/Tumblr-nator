<?php
namespace App\Model;

use Cake\Core\Configure;

class Blog {
    private $pageSize;
    public $posts;
    public $api_key;
    public $blog_name;

    public function __construct($blog_name) {
        $this->api_key = Configure::read('tumblr_api');
        $this->pageSize = Configure::read('page_size');
        $this->blog_name = $blog_name;
        $this->loadPosts();
    }

    private function loadPosts() {
        $this->posts = array();
        $numPosts = $this->numPosts();
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

            $posts = $this->loadPostsRange($this->blog_name, $start);
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


    private function tumblrApiCall($blog_name, $url) {
        $url .= "&api_key={$this->api_key}";

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

    private function numPosts() {
        $url = "http://api.tumblr.com/v2/blog/{$this->blog_name}/info/?";
        $data = $this->tumblrApiCall($this->blog_name, $url);

        if($data && $data['response'] && $data['response']['blog']) {
            return $data['response']['blog']['posts'];
        }else {
            return -1;
        }
    }

    private function loadPostsRange($offset=0) {
        $api_key = Configure::read('tumblr_api');
        $url = "http://api.tumblr.com/v2/blog/{$this->blog_name}/posts/?limit=10&offset=$offset";
        $data = $this->tumblrApiCall($this->blog_name, $url);

        if($data && $data['response'] && $data['response']['posts']) {
            $posts = $data['response']['posts'];
        }else {
            //Error parsing json
            $posts = array();
        }

        return $posts;
    }

}
?>
