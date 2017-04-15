<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Assoc Carriers Input'), ['action' => 'edit', $assocCarriersInput->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Assoc Carriers Input'), ['action' => 'delete', $assocCarriersInput->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assocCarriersInput->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Assoc Carriers Inputs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Assoc Carriers Input'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="assocCarriersInputs view large-9 medium-8 columns content">
    <h3><?= h($assocCarriersInput->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($assocCarriersInput->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Id Carrier') ?></th>
            <td><?= $this->Number->format($assocCarriersInput->id_carrier) ?></td>
        </tr>
        <tr>
            <th><?= __('Id Input') ?></th>
            <td><?= $this->Number->format($assocCarriersInput->id_input) ?></td>
        </tr>
    </table>
</div>
