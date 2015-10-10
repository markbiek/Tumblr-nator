<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

if (!Configure::read('debug')):
    throw new NotFoundException();
endif;

$cakeDescription = 'Mark Biek | Code Test | Via Studio';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <?= $this->Html->css('cover.css') ?>
</head>
<body class="home">
<div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">Tumblr-nator</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="/via">Home</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">Enter a Tumblr blog name:</h1>
            <p class="lead">
                <?php
                    echo $this->Form->create(false, array('type'=> 'post'));
                    echo $this->Form->input('blog_name', array('label'=> false, 'class'=> 'form-control', "default"=> "everythingharrypotter.tumblr.com"));
                ?>
                <p><small>Blog name can be: domain.com, http://domain.com, blogname.tumblr.com, http://blogname.tumblr.com, or blogname</small></p>
                <?php
                echo $this->Form->submit('Load', array('class'=> 'btn btn-primary'));
                echo $this->Form->end();
                ?>
            </p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Code Test for <a href="http://viastudio.com">Via Studio</a>, by <a href="https://https://careers.stackoverflow.com/markbiek">Mark Biek</a>.</p>
            </div>
          </div>

        </div>

      </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <?= $this->Html->script('ie10-viewport-bug-workaround.js'); ?>
</body>
</html>
