<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('List Packagings'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste Produits'), ['controller' => 'products', 'action' => 'index']) ?> </li>
        <!--li></?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $packaging->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $packaging->id)]
            )
        ?></li-->
        <li><?= $this->Html->link(__('List Packagings'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="packagings form large-9 medium-8 columns content">
    <?= $this->Form->create($packaging) ?>
    <fieldset>
        <div class="nopadding panel panel-info">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Edit Packaging') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <?php
                        echo $this->Form->input('name', ['label' => 'Nom', 'class'=>'input-style form-control input-20']);
                        echo $this->Form->input('type', ['label' => 'Type', 'class'=>'input-style form-control input-20']);
                        echo $this->Form->input('weight', ['label' => 'Poids (Kg)', 'class'=>'input-style form-control input-10']);
                    ?>
                </div>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
