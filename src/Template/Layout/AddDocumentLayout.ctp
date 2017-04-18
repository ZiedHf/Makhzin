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

$cakeDescription = APP_NAME;
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?> -
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('/bootstrap/css/bootstrap.min.css') ?>
    
    <?= $this->Html->script('jquery.min.js') ?>
    
    <?= $this->Html->css('/fileinput-master/css/fileinput.min.css') ?>
    
    <?= $this->Html->script('/fileinput-master/js/plugins/canvas-to-blob.min.js') ?>
    <?= $this->Html->script('/fileinput-master/js/fileinput.js') ?>
    
    <?= $this->Html->script('/bootstrap/js/bootstrap.min.js') ?>
    <?= $this->Html->script('/fileinput-master/js/fileinput_locale_fr.js') ?>
    
    <?= $this->Html->css('/font-awesome/css/font-awesome.min.css') ?>
    
    
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    
    <?= $this->Flash->render() ?>
    <div class="container-fluid clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
                
        <?= $this->Html->script('myscript'); ?>
        <?php echo $this->fetch('script'); ?>
        
    </footer>
</body>
</html>
