<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Assoc Carriers Input'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="assocCarriersInputs index large-9 medium-8 columns content">
    <h3><?= __('Assoc Carriers Inputs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('id_carrier') ?></th>
                <th><?= $this->Paginator->sort('id_input') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assocCarriersInputs as $assocCarriersInput): ?>
            <tr>
                <td><?= $this->Number->format($assocCarriersInput->id) ?></td>
                <td><?= $this->Number->format($assocCarriersInput->id_carrier) ?></td>
                <td><?= $this->Number->format($assocCarriersInput->id_input) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $assocCarriersInput->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $assocCarriersInput->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $assocCarriersInput->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assocCarriersInput->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
