<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->layout = false;
$this->extend('/Layout/cross-layout');

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace src/Template/Pages/home.ctp with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'CakePHP: the rapid development PHP framework';
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
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('home.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
<body class="home">

    <div class="row mt-5">
        <h3>Chỉnh sửa Blog</h3>
    </div>
    <div class="row">
        <p>Home <i class="fa fa-angle-right" style="display: inline-block;margin:0 15px"></i> <?= $this->Html->link('Blogs', ['action' => 'index']) ?> 
            <i class="fa fa-angle-right" style="display: inline-block;margin:0 15px"></i> Edit</p>
    </div>
    <div class="row">
        <?php
            echo $this->Form->create($blogModelView);
            // Hard code the user for now.
            echo $this->Form->control('id', ['value'=> $blogModelView->id, 'type' => 'hidden']);
            echo $this->Form->control('title', ['value'=> $blogModelView->title]);
            echo $this->Form->control('content', ['rows' => '3', 'value'=> $blogModelView->content]);
            echo $this->Form->button(__('Save Article'));
            echo $this->Form->end();
        ?>

        <?php
            echo $this->FormError->create($errors);
        ?>
    </div>

</body>
</html>
