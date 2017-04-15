<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('List Carriers'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="carriers form large-9 medium-8 columns content">
    <?= $this->Form->create($carrier) ?>
    <div class="block form-group">
        <fieldset>
            <div class="nopadding panel panel-success">
                <div class="panel-heading">
                    <legend class="labelClass"><?= __('Add Carrier') ?></legend>
                </div>
                <div class="panel-body">
                    <?php
                        echo $this->Form->input('name' , ['label'=>'Raison sociale', 'class'=>'input-30 input-style form-control']);
                        echo $this->Form->input('matriculeFiscale' , ['label'=>'Matricule Fiscale', 'class'=>'input-15 input-style form-control']);
                        echo $this->Form->input('tel', ['label'=>'Téléphone', 'class'=>'input-15 input-style form-control']);
                        echo $this->Form->input('text', ['label'=>'Description', 'rows' => '8', 'class'=>'input-30 form-control']);
                    ?>
                </div>
            </div>
        </fieldset>
    </div>
    <?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
