<?=$this->assign('title', 'Bons de sortie');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('New Output'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lot'), ['controller' => 'Lots', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Outputsets'), ['controller' => 'OutputSets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Outputset'), ['controller' => 'OutputSets', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="outputs index large-9 medium-8 columns content">
    <h3><?= __('Outputs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('date') ?></th>
                <th><?= $this->Paginator->sort('qte') ?></th>
                <th><?= $this->Paginator->sort('lot_id') ?></th>
                <th><?= $this->Paginator->sort('file_id') ?></th>
                <th><?= $this->Paginator->sort('outputSet_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($outputs as $output): ?>
            <tr>
                <td><?= $this->Number->format($output->id) ?></td>
                <td><?= h($output->date) ?></td>
                <td><?= $this->Number->format($output->qte) ?></td>
                <td><?= $output->has('lot') ? $this->Html->link($output->lot->id, ['controller' => 'Lots', 'action' => 'view', $output->lot->id]) : '' ?></td>
                <td><?= $output->has('file') ? $this->Html->link($output->file->number, ['controller' => 'Files', 'action' => 'view', $output->file->id]) : '' ?></td>
                <td><?= $this->Number->format($output->outputSet_id) ?></td>
                <td><?= h($output->created) ?></td>
                <td><?= h($output->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $output->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $output->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $output->id], ['confirm' => __('Are you sure you want to delete # {0}?', $output->id)]) ?>
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
        <p><?= $this->Paginator->counter('{{page}} sur {{pages}}') ?></p>
    </div>
</div>
