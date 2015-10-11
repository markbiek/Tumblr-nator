<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class TumblrForm extends Form {
    protected function _buildSchema(Schema $schema) {
        return $schema->addField('blog_name', 'string');
    }

    protected function _buildValidator(Validator $validator) {
        return $validator->add('blog_name', 'length', [
                'rule'=> ['minLength', 1],
                'message'=> 'A blog name is required.'
            ]);
    }

    protected function _execute(array $data) {
        return true;
    }
}
?>
