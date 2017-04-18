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
    throw new NotFoundException('Please replace src/Template/Pages/home.ctp with your own version.');
endif;

$cakeDescription = 'Makhzin';
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
    
    <?= $this->Html->css('cake.css') ?>
    
    <?= $this->Html->css('/bootstrap/css/bootstrap.min.css') ?>
    <?= $this->Html->css('justified-nav') ?>
    <?= $this->Html->css('/bootstrap-select/dist/css/bootstrap-select.min.css') ?>
    <?= $this->Html->css('/font-awesome/css/font-awesome.min.css') ?>
</head>
<body cz-shortcut-listen="true">
    <?= $this->Flash->render() ?>
    <?= $this->Flash->render('auth') ?>
    
    
    <div class="container">
        
        <div class="jumbotronHeader jumbotron">
            <div class="container">
                <div class="col-md-5"><?= $this->Html->image('logos/logo-tn.png', ['class' => 'logo-tn']); ?></div>
                <div class="col-md-2"><h2 class="nameApp"><?=APP_NAME?><sub class="versionApp"><?=APP_VERSION?></sub></h2></div>
                <!--div class="col-md-2"></?= $this->Html->image('logos/logo-palliserIntr.png', ['class' => 'logo-palliser']); ?></div-->
                <div class="col-md-5"><?= $this->Html->image('logos/logo-douane.png', ['class' => 'logo-douane pull-right']); ?></div>
            </div>
        </div>
        
      <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <div class="masthead">
        <!--h3 class="text-muted"></h3-->
        <nav>
          <ul class="nav nav-justified">
            <li><?= $this->Html->link(__('Nos Dossiers'), ['controller' => 'Files', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Nos Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Nos Produits'), ['controller' => 'Products', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Nos Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Nos Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Espace membre'), ['controller' => 'Users', 'action' => 'index']) ?></li>
            <li><?=$this->Html->link('<i class="fa fa-sign-out" aria-hidden="true" style="color:red;"></i>', ['controller' => 'Users', 'action' => 'logout'], ['escape' => false])?></li>
          </ul>
        </nav>
      </div>

      <!-- Jumbotron -->
      <div class="jumbotron jumbotronTr">
        <div class="titre-login"><?= $this->Html->image(COMPANY_LOGO, ['class' => 'logo-palliser']); ?></div>
        <h2>Gestion d'un entrepôt sous douane pour l'autrui</h2>
        <p class="lead"><h3>App. <?=APP_NAME?></h3> <br> V.<?=APP_VERSION?></p>
      </div>

      <!-- Site footer -->
      <footer class="footer">
          <p>© 2016 <a href="http://khidma.tn" target="_blank">Khidma.tn</a>.</p>
        <?= $this->Html->script('jquery.min.js') ?>
        <?= $this->Html->script('/bootstrap/js/bootstrap.min.js') ?>
      </footer>

    </div> <!-- /container -->

</body>
</html>
