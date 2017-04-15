<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('List Productstates'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste Produits'), ['controller' => 'products', 'action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="productstates form large-9 medium-8 columns content">
    <?= $this->Form->create($productstate) ?>
    <fieldset>
        <div class="nopadding panel panel-info">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Add Productstate') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <?php
                        echo $this->Form->input('name', ['class'=>'input-20 input-style form-control', 'required' => true]);
                        //echo $this->Form->input('created_by');
                        //echo $this->Form->input('modified_by');
                    ?>
                </div>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button('Envoyer', ['id' => 'btnEnvoyer', 'type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
