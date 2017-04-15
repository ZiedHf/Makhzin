<?=$this->assign('title', 'Utilisateurs');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?></li>
        <li><?= ($id == $id_user) ? $this->Html->link(__('Edit User password'), ['action' => 'editmyprofile', $user->id]) : '' ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <div class="nopadding panel panel-danger">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Edit User') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <div class="block form-group">
                        <div class="col-md-12 display-flex">
                            <div class="col-md-6 panel panel-default panel-border">
                                <div class="panel-heading">Inforamtions et privilége</div>
                                <div class="panel-body">
                                    <?php
                                        echo $this->Form->input('username', ['label' => 'Nom Utilisateur', 'class'=>'input-style form-control input-40', 'disabled' => true]);
                                        echo $this->Form->input('role', ['options' => $membreType, 'label' => 'Rôle', 'class'=>'input-style form-control input-40']);
                                        echo $this->Form->input('products', ['class'=>'input-style form-control input-40', 'options' => $privilege]);
                                        echo $this->Form->input('categories', ['class'=>'input-style form-control input-40', 'options' => $privilege]);
                                        echo $this->Form->input('clients', ['class'=>'input-style form-control input-40', 'options' => $privilege]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6 panel panel-default panel-border">
                                <div class="panel-heading">Privilége</div>
                                <div class="panel-body">
                                    <?php
                                        echo $this->Form->input('files', ['class'=>'input-style form-control input-40', 'options' => $privilege]);
                                        echo $this->Form->input('lots', ['class'=>'input-style form-control input-40', 'options' => $privilege]);
                                        echo $this->Form->input('users', ['class'=>'input-style form-control input-40', 'options' => $priv_user]);
                                    ?>
                                </div>
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
