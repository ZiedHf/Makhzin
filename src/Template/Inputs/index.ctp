<?=$this->assign('title', 'Bons d\'entrée');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('New Input'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lot'), ['controller' => 'Lots', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="inputs index large-9 medium-8 columns content">
    <h3><?= __('Inputs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('date') ?></th>
                <th><?= $this->Paginator->sort('file_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inputs as $input): ?>
            <tr>
                <td><?= $this->Number->format($input->id) ?></td>
                <td><?= h($input->date) ?></td>
                <td><?= $this->Number->format($input->file_id) ?></td>
                <td><?= h($input->created) ?></td>
                <td><?= h($input->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $input->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $input->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $input->id], ['confirm' => __('Are you sure you want to delete # {0}?', $input->id)]) ?>
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
