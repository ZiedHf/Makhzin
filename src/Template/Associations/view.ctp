<?=$this->assign('title', 'Associations');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Edit Association'), ['action' => 'edit', $association->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Association'), ['action' => 'delete', $association->id], ['confirm' => __('Are you sure you want to delete # {0}?', $association->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Associations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Association'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="associations view large-9 medium-8 columns content">
    <h3><?= h($association->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Category') ?></th>
            <td><?= $association->has('category') ? $this->Html->link($association->category->name, ['controller' => 'Categories', 'action' => 'view', $association->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Product') ?></th>
            <td><?= $association->has('product') ? $this->Html->link($association->product->name, ['controller' => 'Products', 'action' => 'view', $association->product->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($association->id) ?></td>
        </tr>
    </table>
</div>
