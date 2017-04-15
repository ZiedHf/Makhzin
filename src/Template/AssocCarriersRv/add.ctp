<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Assoc Carriers Rv'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="assocCarriersRv form large-9 medium-8 columns content">
    <?= $this->Form->create($assocCarriersRv) ?>
    <fieldset>
        <legend><?= __('Add Assoc Carriers Rv') ?></legend>
        <?php
            echo $this->Form->input('id_carrier');
            echo $this->Form->input('id_rv');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
