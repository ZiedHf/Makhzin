<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Edit Packaging'), ['action' => 'edit', $packaging->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Packaging'), ['action' => 'delete', $packaging->id], ['confirm' => __('Are you sure you want to delete # {0}?', $packaging->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Packagings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Packaging'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="packagings view large-9 medium-8 columns content">
    <div class="nopadding panel panel-info">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= h($packaging->name) ?></h3>
        </div>
        <div class="panel-body">
            <table class="vertical-table table-viewVertical">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($packaging->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= h($packaging->users__created_by->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified By') ?></th>
                    <td><?= (isset($packaging->users__modified_by->username)) ? h($packaging->users__modified_by->username) : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($packaging->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($packaging->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
