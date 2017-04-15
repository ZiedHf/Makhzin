<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('List Movements'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Stocks'), ['controller' => 'Stocks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Stock'), ['controller' => 'Stocks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lot'), ['controller' => 'Lots', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="movements form large-9 medium-8 columns content">
    <?= $this->Form->create($movement) ?>
    <fieldset>
        <legend><?= __('Add Movement') ?></legend>
        <?php
            echo $this->Form->input('type');
            echo $this->Form->input('date', ['empty' => true]);
            echo $this->Form->input('qte');
            echo $this->Form->input('before');
            echo $this->Form->input('after');
            echo $this->Form->input('stock_id', ['options' => $stocks, 'empty' => true]);
            echo $this->Form->input('lot_id', ['options' => $lots, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
