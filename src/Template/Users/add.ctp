<?=$this->assign('title', 'Utilisateurs');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>

<div class="users form large-9 medium-8 columns content">
<?= $this->Form->create($user) ?>
    <fieldset>
        <div class="nopadding panel panel-danger">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Add User') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <div class="col-md-12 display-flex">
                        <div class="col-md-6 panel panel-default panel-border">
                            <div class="panel-heading">Inforamtions</div>
                            <div class="panel-body">
                                <?= $this->Form->input('username', ['class'=>'input-style form-control input-40']) ?>
                                <?= $this->Form->input('password', ['id' => 'password1', 'class'=>'input-style form-control input-40']) ?>
                                <?= $this->Form->label('password2', 'Confirmation de mot de passe') ?>
                                <?= $this->Form->input('password2', ['id' => 'password2', 'label'=>false, 'templates' => ['inputContainer' => '<div id="add-mark-pw" class="input password required">{{content}}</div>'], 'type' => 'password', 'class'=>'inline-block input-style form-control input-40', 'required' => true]) ?>

                                <?= $this->Form->input('role', [ 'id' => 'role_select',
                                    'options' => $membreType,
                                    'empty' => true, 'class'=>'input-style form-control input-40'
                                ]) ?>
                                <?php




                                ?>
                            </div>
                        </div>
                        <div class="col-md-6 panel panel-default panel-border">
                            <div class="panel-heading">Privilége</div>
                            <div class="panel-body">
                            <?php
                                echo $this->Form->input('products', ['id' => 'products_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                echo $this->Form->input('categories', ['id' => 'categories_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                //echo $this->Form->input('zones', ['id' => 'zones_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                //echo $this->Form->input('dependencies', ['id' => 'dependecies_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                echo $this->Form->input('clients', ['id' => 'clients_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                //echo $this->Form->input('providers', ['id' => 'providers_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                echo $this->Form->input('files', ['id' => 'files_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                echo $this->Form->input('lots', ['id' => 'lots_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                //echo $this->Form->input('movements', ['id' => 'movements_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                //echo $this->Form->input('stocks', ['id' => 'stocks_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                //echo $this->Form->input('inputs', ['id' => 'inputs_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                //echo $this->Form->input('outputSets', ['id' => 'outputSets_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                //echo $this->Form->input('outputs', ['id' => 'outputs_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                //echo $this->Form->input('documents', ['id' => 'documents_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                //echo $this->Form->input('required_docs', ['id' => 'required_select', 'options' => $privilege, 'class'=>'input-style form-control input-40']);
                                echo $this->Form->input('users', ['id' => 'users_select', 'options' => $priv_user, 'class'=>'input-style form-control input-40']);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </fieldset>
<?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
<?= $this->Form->end() ?>
</div>
<?php //echo $text;
    $this->Html->scriptStart(['block' => true]);
        echo "initilizeAddUserPage();";
    $this->Html->scriptEnd();
?>
<!--nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"></?= __('Actions') ?></li>
        <li></?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    </?= $this->Form->create($user) ?>
    <fieldset>
        <legend></?= __('Add User') ?></legend>
        </?php
            echo $this->Form->input('username');
            echo $this->Form->input('password');
            echo $this->Form->input('role');
            echo $this->Form->input('products');
            echo $this->Form->input('categories');
            echo $this->Form->input('providers');
            echo $this->Form->input('stocks');
            echo $this->Form->input('movements');
            echo $this->Form->input('clients');
            echo $this->Form->input('lots');
            echo $this->Form->input('zones');
            echo $this->Form->input('files');
            echo $this->Form->input('inputs');
            echo $this->Form->input('documents');
            echo $this->Form->input('outputSets');
            echo $this->Form->input('required_docs');
            echo $this->Form->input('outputs');
        ?>
    </fieldset>
    </?= $this->Form->button(__('Submit')) ?>
    </?= $this->Form->end() ?>
</div-->
