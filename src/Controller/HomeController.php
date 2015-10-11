<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateExceiont;
use App\Form\TumblrForm;

class HomeController extends AppController {
    private function cleanBlogName($blog_name) {
        $blog_name = str_replace('http://', '', strtolower($blog_name));
        $blog_name = trim($blog_name, '/');
        if(strpos(strtolower($blog_name), 'tumblr.com') === false) {
            $blog_name .= '.tumblr.com';
        }

        return $blog_name;
    }

    public function display() {
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
            }else {
                $session->write("Home.blogName", $data['blog_name']);
            }
            $data['blog_name'] = $this->cleanBlogName($this->request->data['blog_name']);

        }else {
            $data['blog_name'] = $session->read("Home.blogName");
        }

        /*
        if($this->loadPosts($data['blog_name'])) {
            $this->Paginator->settings = $this->paginate;
            $data['posts'] = $this->Paginator->paginate('Home');
        }
        */

        $this->set('form', $form);
        $this->set($data);
    }

}
?>
