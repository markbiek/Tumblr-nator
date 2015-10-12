<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use App\Form\TumblrForm;
use App\Model\Blog;

class HomeController extends AppController {
    public $components = array('Paginator');

    private function cleanBlogName($blog_name) {
        $blog_name = str_replace('http://', '', strtolower($blog_name));
        $blog_name = trim($blog_name, '/');
        if(strpos(strtolower($blog_name), 'tumblr.com') === false) {
            $blog_name .= '.tumblr.com';
        }

        return $blog_name;
    }

    //We use this action to query posts at a certain offset from JS
    //Otherwise we run into same-origin issues querying the Tumblr api
    public function posts() {
        header("Content-Type: application/json");

        $this->autoRender = false;
        $session = $this->request->session();
        if(!array_key_exists('offset', $this->request->query)) { 
            echo json_encode([
                    'status'=> 'error',
                    'msg'=> 'Invalid request'
                ]);
        }else {
            $offset = $this->request->query['offset'];
            $blog_name = $session->read("Home.blogName");

            $blog = new Blog($blog_name);
            $posts = $blog->loadPostsRange($offset);

            echo json_encode($posts);
        }
    }

    public function display() {
        $api_key = Configure::read('tumblr_api');
        $form = new TumblrForm();
        $session = $this->request->session();

        $data = [];
        $data['blog_name'] = 'everythingharrypotter.tumblr.com';
        $session->write("Home.blogName", $data['blog_name']);
        $this->set('form_error', '');

        if($this->request->is('post')) {
            if(!$form->execute($this->request->data)) {
                $errors = $form->errors();
                $this->set('form_error', $errors['blog_name']['_empty']);
            }
        }else {
            $data['blog_name'] = $session->read("Home.blogName");
        }

        if(array_key_exists('blog_name', $this->request->data)) {
            //Load the first <n> posts in the controller
            //The rest will happen via ajax
            $data['blog_name'] = $this->cleanBlogName($this->request->data['blog_name']);
            $session->write("Home.blogName", $data['blog_name']);

            $blog = new Blog($data['blog_name']);
            $curOffset = 0;
            $posts = $blog->loadPostsRange($curOffset);
            if(count($posts) <= 0) {
                $this->set('form_error', "Sorry, we couldn't load any posts for that blog.");
            }

            $this->set('api_key', $blog->apiKey);
            $this->set('page_size', $blog->pageSize);
            $this->set('num_posts', $blog->numPosts);
            $this->set('posts', $posts);

            //echo '<pre>' . print_r($posts, true) . '</pre>';
        }else {
            $this->set('posts', []);
        }

        $this->set('form', $form);
        $this->set($data);
    }

}
?>
