<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Edit Movement'), ['action' => 'edit', $movement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Movement'), ['action' => 'delete', $movement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $movement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Movements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Stocks'), ['controller' => 'Stocks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stock'), ['controller' => 'Stocks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lots'), ['controller' => 'Lots', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lot'), ['controller' => 'Lots', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="movements view large-9 medium-8 columns content">
    <h3><?= h($movement->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Stock') ?></th>
            <td><?= $movement->has('stock') ? $this->Html->link($movement->stock->id, ['controller' => 'Stocks', 'action' => 'view', $movement->stock->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Lot') ?></th>
            <td><?= $movement->has('lot') ? $this->Html->link($movement->lot->id, ['controller' => 'Lots', 'action' => 'view', $movement->lot->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($movement->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= $this->Number->format($movement->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Qte') ?></th>
            <td><?= $this->Number->format($movement->qte) ?></td>
        </tr>
        <tr>
            <th><?= __('Before') ?></th>
            <td><?= $this->Number->format($movement->before) ?></td>
        </tr>
        <tr>
            <th><?= __('After') ?></th>
            <td><?= $this->Number->format($movement->after) ?></td>
        </tr>
        <tr>
            <th><?= __('Date') ?></th>
            <td><?= h($movement->date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($movement->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($movement->modified) ?></td>
        </tr>
    </table>
</div>
