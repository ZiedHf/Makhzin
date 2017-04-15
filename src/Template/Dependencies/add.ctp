<?=$this->assign('title', 'Dependances');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('List Dependencies'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="dependencies form large-9 medium-8 columns content">
    <?= $this->Form->create($dependency) ?>
    <fieldset>
        <div class="block form-group">
            <legend><?= __('Ajouter Dépendance') ?></legend><br>
            <?php
                $nameCat = $category['name'];
                $idCat = $category['id'];
                //debug($nameCat);die();
                echo $this->Form->input('this_category', ['label' => 'Première Categorie', 'value' => $nameCat, 'class'=>'input-style form-control input-20', 'disabled' => true]);
                echo $this->Form->input('id_category1', ['type' => 'hidden', 'value' => $idCat]);
                echo $this->Form->input('id_category2', ['label' => 'Deuxième Categorie', 'empty' => true, 'options' => $categories, 'class'=>'input-style form-control input-20']);
                echo $this->Form->input('quota', ['class'=>'input-style form-control input-15', 'type' => 'number', 'step' => 'any', 'min' => '0', 'required' => true]);
                echo $this->Form->input('tolerance', ['label' => 'Tolérance', 'class'=>'input-style form-control input-15', 'type' => 'number', 'step' => 'any', 'min' => '0']);
            ?>
        </div>
    </fieldset>
    <?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
