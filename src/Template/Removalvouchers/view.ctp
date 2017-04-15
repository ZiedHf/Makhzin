<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Edit Removalvoucher'), ['action' => 'edit', $removalvoucher->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Removalvoucher'), ['action' => 'delete', $removalvoucher->id], ['confirm' => __('Are you sure you want to delete # {0}?', $removalvoucher->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Removalvouchers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Removalvoucher'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="removalvouchers view large-9 medium-8 columns content">
    <h3><?= h($removalvoucher->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Number') ?></th>
            <td><?= h($removalvoucher->number) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($removalvoucher->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created By') ?></th>
            <td><?= $this->Number->format($removalvoucher->created_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($removalvoucher->modified_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($removalvoucher->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($removalvoucher->modified) ?></td>
        </tr>
    </table>
</div>
