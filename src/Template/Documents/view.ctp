<?=$this->assign('title', 'Documents');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Edit Document'), ['action' => 'edit', $document->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Document'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Documents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="documents view large-9 medium-8 columns content">
    <div class="well well-sm"><h3><?= h($document->name) ?></h3></div>
    <table class="vertical-table table-view">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($document->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Path') ?></th>
            <td><?= h($document->path) ?></td>
        </tr>
        <tr>
            <th><?= __('File') ?></th>
            <td><?= $document->has('file') ? $this->Html->link($document->file->id, ['controller' => 'Files', 'action' => 'view', $document->file->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($document->id) ?></td>
        </tr>
    </table>
</div>
