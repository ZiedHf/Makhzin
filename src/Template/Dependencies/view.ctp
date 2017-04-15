<?=$this->assign('title', 'Dependances');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Edit Dependency'), ['action' => 'edit', $dependency->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Dependency'), ['action' => 'delete', $dependency->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dependency->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Dependencies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Dependency'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="dependencies view large-9 medium-8 columns content">
    <h3><?= h($dependency->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Category') ?></th>
            <td><?= $dependency->has('category') ? $this->Html->link($dependency->category->name, ['controller' => 'Categories', 'action' => 'view', $dependency->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($dependency->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Id Category2') ?></th>
            <td><?= $this->Number->format($dependency->id_category2) ?></td>
        </tr>
        <tr>
            <th><?= __('Quota') ?></th>
            <td><?= $this->Number->format($dependency->quota) ?></td>
        </tr>
    </table>
</div>
