<?=$this->assign('title', 'Associations');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('New Association'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="associations index large-9 medium-8 columns content">
    <h3><?= __('Associations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('category_id') ?></th>
                <th><?= $this->Paginator->sort('product_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($associations as $association): ?>
            <tr>
                <td><?= $this->Number->format($association->id) ?></td>
                <td><?= $association->has('category') ? $this->Html->link($association->category->name, ['controller' => 'Categories', 'action' => 'view', $association->category->id]) : '' ?></td>
                <td><?= $association->has('product') ? $this->Html->link($association->product->name, ['controller' => 'Products', 'action' => 'view', $association->product->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $association->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $association->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $association->id], ['confirm' => __('Are you sure you want to delete # {0}?', $association->id)]) ?>
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
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
