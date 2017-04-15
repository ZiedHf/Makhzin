<?=$this->assign('title', 'Stocks');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Edit Stock'), ['action' => 'edit', $stock->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Stock'), ['action' => 'delete', $stock->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stock->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Stocks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stock'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Movements'), ['controller' => 'Movements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movement'), ['controller' => 'Movements', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="stocks view large-9 medium-8 columns content">
    <div class="well well-sm"><h3><?= h($stock->id) ?></h3></div>
    <table class="vertical-table table-view">
        <tr>
            <th><?= __('Unit') ?></th>
            <td><?= h($stock->unit) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($stock->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Amount') ?></th>
            <td><?= $this->Number->format($stock->amount) ?></td>
        </tr>
        <tr>
            <th><?= __('UnitQte') ?></th>
            <td><?= $this->Number->format($stock->unitQte) ?></td>
        </tr>
        <tr>
            <th><?= __('Product Id') ?></th>
            <td><?= $this->Number->format($stock->product_id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Products') ?></h4>
        <?php if (!empty($stock->products)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('ProductCode') ?></th>
                <th><?= __('NgpCode') ?></th>
                <th><?= __('BarCode') ?></th>
                <th><?= __('SubjectToQuota') ?></th>
                <th><?= __('Quota') ?></th>
                <th><?= __('Tolerance') ?></th>
                <th><?= __('Approved') ?></th>
                <th><?= __('Emballage') ?></th>
                <th><?= __('UnitQte') ?></th>
                <th><?= __('Unit') ?></th>
                <th><?= __('Category Id') ?></th>
                <th><?= __('Stock Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($stock->products as $products): ?>
            <tr>
                <td><?= h($products->id) ?></td>
                <td><?= h($products->name) ?></td>
                <td><?= h($products->productCode) ?></td>
                <td><?= h($products->ngpCode) ?></td>
                <td><?= h($products->barCode) ?></td>
                <td><?= h($products->subjectToQuota) ?></td>
                <td><?= h($products->quota) ?></td>
                <td><?= h($products->tolerance) ?></td>
                <td><?= h($products->approved) ?></td>
                <td><?= h($products->emballage) ?></td>
                <td><?= h($products->unitQte) ?></td>
                <td><?= h($products->unit) ?></td>
                <td><?= h($products->category_id) ?></td>
                <td><?= h($products->stock_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Products', 'action' => 'view', $products->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Products', 'action' => 'edit', $products->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Products', 'action' => 'delete', $products->id], ['confirm' => __('Are you sure you want to delete # {0}?', $products->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <div class="panel panel-default">
            <div class="panel-body"><?=__('VideM', ['produit'])?></div>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Movements') ?></h4>
        <?php if (!empty($stock->movements)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Type') ?></th>
                <th><?= __('Date') ?></th>
                <th><?= __('Qte') ?></th>
                <th><?= __('Before') ?></th>
                <th><?= __('After') ?></th>
                <th><?= __('Stock Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($stock->movements as $movements): ?>
            <tr>
                <td><?= h($movements->id) ?></td>
                <td><?= h($movements->type) ?></td>
                <td><?= h($movements->date) ?></td>
                <td><?= h($movements->qte) ?></td>
                <td><?= h($movements->before) ?></td>
                <td><?= h($movements->after) ?></td>
                <td><?= h($movements->stock_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Movements', 'action' => 'view', $movements->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Movements', 'action' => 'edit', $movements->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Movements', 'action' => 'delete', $movements->id], ['confirm' => __('Are you sure you want to delete # {0}?', $movements->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
