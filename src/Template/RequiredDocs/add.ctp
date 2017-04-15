<?=$this->assign('title', 'Types des documets');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Liste Types'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="requiredDocs form large-9 medium-8 columns content">
    <?= $this->Form->create($requiredDoc) ?>
    <fieldset>
        <div class="nopadding panel panel-warning">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Ajouter une catégorie des documents') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <?php
                        echo $this->Form->label('name', 'Nom document', ['class' => 'label-style']);
                        echo $this->Form->input('name', ['label' => false, 'class'=>'input-style form-control input-30']);
                        echo $this->Form->label('type', 'Type document', ['class' => 'label-style']);
                        echo $this->Form->input('type', ['option' => $types, 'empty' => false, 'label' => false, 'class'=>'input-style form-control input-30', 'required' => true]);
                    ?>
                </div>
            </div>
        </div>
    </fieldset>
    <!--</?= $this->Form->button(__('Submit')) ?>-->
    <?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
