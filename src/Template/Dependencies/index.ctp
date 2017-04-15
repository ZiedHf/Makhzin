<?=$this->assign('title', 'Dependances');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('New Dependency'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="dependencies index large-9 medium-8 columns content">
    <h3><?= __('Dependencies') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('id_category1') ?></th>
                <th><?= $this->Paginator->sort('id_category2') ?></th>
                <th><?= $this->Paginator->sort('quota') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dependencies as $dependency): ?>
            <tr>
                <td><?= $this->Number->format($dependency->id) ?></td>
                <td><?= $dependency->has('category') ? $this->Html->link($dependency->category->name, ['controller' => 'Categories', 'action' => 'view', $dependency->category->id]) : '' ?></td>
                <td><?= $this->Html->link($categories[$dependency->id_category2], ['controller' => 'Categories', 'action' => 'view', $this->Number->format($dependency->id_category2)]) ?></td>
                <td><?= $this->Number->format($dependency->quota) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $dependency->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                    <?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['action' => 'edit', $dependency->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                    <?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['action' => 'delete', $dependency->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $dependency->id)]) ?>
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
