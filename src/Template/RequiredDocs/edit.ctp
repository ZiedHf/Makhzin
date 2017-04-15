<?=$this->assign('title', 'Types des documets');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Form->postLink(
                __('Supprimer'),
                ['action' => 'delete', $requiredDoc->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $requiredDoc->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('Nouveau Type'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="requiredDocs form large-9 medium-8 columns content">
    <?= $this->Form->create($requiredDoc) ?>
    <fieldset>
        <div class="nopadding panel panel-warning">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Modifier un type des documents') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <?php
                        echo $this->Form->label('name', 'Nom Document', ['class' => 'label-style']);
                        echo $this->Form->input('name', ['label' => false, 'class'=>'input-style form-control input-30']);
                        echo $this->Form->label('type', 'Type de document', ['class' => 'label-style']);
                        //echo $this->Form->input('type', ['label' => false, 'class'=>'input-style form-control']);
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
