<?=$this->assign('title', 'Dependances');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $dependency->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $dependency->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Dependencies'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="dependencies form large-9 medium-8 columns content">
    <?= $this->Form->create($dependency) ?>
    <fieldset>
        <div class="block form-group">
            <legend><?= __('Edit Dependency') ?></legend><br>
            <?php
                echo $this->Form->input('id_category1', ['label' => 'Première Categorie', 'options' => $categories, 'class'=>'input-style form-control input-20', 'disabled' => true]);
                echo $this->Form->input('id_category2', ['label' => 'Deuxième Categorie', 'options' => $categories, 'class'=>'input-style form-control input-20', 'disabled' => true]);
                echo $this->Form->input('quota', ['class'=>'input-style form-control input-15', 'type' => 'number', 'step' => 'any', 'min' => '0', 'required' => true]);
                echo $this->Form->input('tolerance', ['label' => 'Tolérance', 'class'=>'input-style form-control input-15', 'type' => 'number', 'step' => 'any', 'min' => '0']);
            ?>
        </div>
    </fieldset>
    <?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
