<?=$this->assign('title', 'Documents');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <!--<li></?= $this->Html->link(__('New Document'), ['action' => 'add']) ?></li>-->
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="documents index large-9 medium-8 columns content">
    <h3><?= __('Documents') ?></h3>
    <table cellpadding="0" cellspacing="0" class="block_table table table-responsive">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('path') ?></th>
                <th><?= $this->Paginator->sort('file_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documents as $document): ?>
            <tr>
                <td><?= $this->Number->format($document->id) ?></td>
                <td><?= h($document->name) ?></td>
                <td><?= h($document->path) ?></td>
                <td><?= $document->has('file') ? $this->Html->link($document->file->id, ['controller' => 'Files', 'action' => 'view', $document->file->id]) : '' ?></td>
                <td class="actions">
                    <!--</?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $document->id], ['class' => 'btn btn-primary btn-md', 'escape' => false]) ?>-->
                    <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), DS.'webroot'.DS.'uploads'.DS.$document->path, ['class' => 'btn btn-primary btn-sm', 'target' => '_blank', 'escape' => false]) ?>
                    <!--</?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['action' => 'edit', $document->id], ['class' => 'btn btn-info btn-md', 'escape' => false]) ?>-->
                    <?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['action' => 'delete', $document->id], ['class' => 'btn btn-danger btn-md', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?>
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
