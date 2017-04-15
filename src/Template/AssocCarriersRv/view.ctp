<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Assoc Carriers Rv'), ['action' => 'edit', $assocCarriersRv->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Assoc Carriers Rv'), ['action' => 'delete', $assocCarriersRv->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assocCarriersRv->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Assoc Carriers Rv'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Assoc Carriers Rv'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="assocCarriersRv view large-9 medium-8 columns content">
    <h3><?= h($assocCarriersRv->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($assocCarriersRv->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Id Carrier') ?></th>
            <td><?= $this->Number->format($assocCarriersRv->id_carrier) ?></td>
        </tr>
        <tr>
            <th><?= __('Id Rv') ?></th>
            <td><?= $this->Number->format($assocCarriersRv->id_rv) ?></td>
        </tr>
    </table>
</div>
