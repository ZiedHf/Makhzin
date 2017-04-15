<?=$this->assign('title', 'Utilisateurs');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?></li>
        <li><?= $this->Html->link(__('Aller à la page précédente'), ['action' => 'view', $id]) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <div class="block form-group">
            <legend><?= __('Edit User') ?></legend>
            <div class="block form-group">
                <?php
                    //echo $this->Form->input('username', ['label' => 'Nom Produit', 'class'=>'input-style form-control input-30', 'disable' => true]);
                    echo $this->Form->input('password_old', ['type' => 'password', 'label' => 'Ancien mot de passe', 'class'=>'input-style form-control input-30']);
                    echo $this->Form->input('password_new', ['id' => 'password1', 'type' => 'password', 'label' => 'Nouveau mot de passe', 'class'=>'input-style form-control input-30']);
                    echo $this->Form->label('password_new2', 'Confirmation de mot de passe');
                    echo $this->Form->input('password_new2', ['id' => 'password2', 'type' => 'password', 'label' => false, 'templates' => ['inputContainer' => '<div id="add-mark-pw" class="input password required">{{content}}</div>'], 'class'=>'inline-block input-style form-control input-30']);
                ?>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
<?php //echo $text;
    $this->Html->scriptStart(['block' => true]);
        echo "initilizeEditMyProfileUserPage();";
    $this->Html->scriptEnd();
?>
