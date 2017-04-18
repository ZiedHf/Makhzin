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
    <nav class="navbar navbar-inverse navbar-static-top marginBottom-0" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
              <?= $this->Html->link('<i class="fa fa-home" aria-hidden="true"></i> '.APP_NAME, ['controller' => 'Pages', 'action' => 'display'], ['class' =>'navbar-brand', 'escape' => false]) ?>
            </div>
            
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-files-o" aria-hidden="true"></i> Dossiers <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?= $this->Html->link('<i class="fa fa-list-ul" aria-hidden="true"></i> Liste des dossiers', ['controller' => 'Files', 'action' => 'index'], ['escape' => false]) ?></li>
                            <li><?= $this->Html->link('<i class="fa fa-plus-square" aria-hidden="true"></i> Nouveau dossier', ['controller' => 'Files', 'action' => 'add'], ['escape' => false]) ?></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown dropdown-submenu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Types des documents</a>
                                <ul class="dropdown-menu">
                                        <li><?= $this->Html->link('<i class="fa fa-list-ul" aria-hidden="true"></i> Liste des types', ['controller' => 'RequiredDocs', 'action' => 'index'], ['escape' => false]) ?></li>
                                        <li><?= $this->Html->link('<i class="fa fa-plus-square" aria-hidden="true"></i> Nouveau type', ['controller' => 'RequiredDocs', 'action' => 'add'], ['escape' => false]) ?></li>
                                </ul>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><?= $this->Html->link('<i class="fa fa-list-ul" aria-hidden="true"></i> Liste des lots', ['controller' => 'Lots', 'action' => 'index'], ['escape' => false]) ?></li>
                            <li role="separator" class="divider"></li>
                            <li><?= $this->Html->link('<i class="fa fa-exchange" aria-hidden="true"></i> Mouvements', ['controller' => 'Movements', 'action' => 'index'], ['escape' => false]) ?></li>
                        </ul>
                    </li>
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cubes" aria-hidden="true"></i> Produits<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?= $this->Html->link('<i class="fa fa-list-ul" aria-hidden="true"></i> Liste des produits', ['controller' => 'Products', 'action' => 'index'], ['escape' => false]) ?></li>
                            <li><?= $this->Html->link('<i class="fa fa-plus-square" aria-hidden="true"></i> Nouveau produit', ['controller' => 'Products', 'action' => 'add'], ['escape' => false]) ?></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown dropdown-submenu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-archive" aria-hidden="true"></i> Catégories</a>
                                <ul class="dropdown-menu">
                                        <li><?= $this->Html->link('<i class="fa fa-list-ul" aria-hidden="true"></i> Liste des catégories', ['controller' => 'Categories', 'action' => 'index'], ['escape' => false]) ?></li>
                                        <li><?= $this->Html->link('<i class="fa fa-plus-square" aria-hidden="true"></i> Nouvelle catégorie', ['controller' => 'Categories', 'action' => 'add'], ['escape' => false]) ?></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users" aria-hidden="true"></i> Clients<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?= $this->Html->link('<i class="fa fa-list-ul" aria-hidden="true"></i> Liste des clients', ['controller' => 'Clients', 'action' => 'index'], ['escape' => false]) ?></li>
                            <li><?= $this->Html->link('<i class="fa fa-user-plus" aria-hidden="true"></i> Nouveau client', ['controller' => 'Clients', 'action' => 'add'], ['escape' => false]) ?></li>
                        </ul>
                    </li>
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-truck" aria-hidden="true"></i> Fournisseurs<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?= $this->Html->link('<i class="fa fa-list-ul" aria-hidden="true"></i> Liste des fournisseurs', ['controller' => 'Providers', 'action' => 'index'], ['escape' => false]) ?></li>
                            <li><?= $this->Html->link('<i class="fa fa-user-plus" aria-hidden="true"></i> Nouveau fournisseur', ['controller' => 'Providers', 'action' => 'add'], ['escape' => false]) ?></li>
                        </ul>
                    </li>
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-th-large" aria-hidden="true"></i> Zones<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?= $this->Html->link('<i class="fa fa-list-ul" aria-hidden="true"></i> Liste des zones', ['controller' => 'Zones', 'action' => 'index'], ['escape' => false]) ?></li>
                            <li><?= $this->Html->link('<i class="fa fa-plus-square" aria-hidden="true"></i> Nouvelle zone', ['controller' => 'Zones', 'action' => 'add'], ['escape' => false]) ?></li>
                        </ul>
                    </li>
                </ul>
                
                <ul class="nav navbar-nav navbar-right">
                    <li><?=$this->Html->link('<span class="glyphicon glyphicon-user"></span> Utilisateur', ['controller' => 'Users', 'action' => 'index'], ['escape' => false])?></li>
                    <li><?=$this->Html->link('<i class="fa fa-sign-out" aria-hidden="true"></i> Déconnexion', ['controller' => 'Users', 'action' => 'logout'], ['escape' => false])?></li>
                    <!--
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown User<span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                      </ul>
                    </li>
                    -->
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
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
