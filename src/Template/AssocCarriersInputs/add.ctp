<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Assoc Carriers Inputs'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="assocCarriersInputs form large-9 medium-8 columns content">
    <?= $this->Form->create($assocCarriersInput) ?>
    <fieldset>
        <legend><?= __('Add Assoc Carriers Input') ?></legend>
        <?php
            echo $this->Form->input('id_carrier');
            echo $this->Form->input('id_input');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
