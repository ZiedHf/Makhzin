<?=$this->assign('title', 'Stocks');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('New Stock'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Movements'), ['controller' => 'Movements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Movement'), ['controller' => 'Movements', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stocks index large-9 medium-8 columns content">
    <h3><?= __('Stocks') ?></h3>
    <table cellpadding="0" cellspacing="0" class="block_table table table-responsive">
        <thead>
            <tr>
                <th class="widthTh10">N°</th>
                <th><?= $this->Paginator->sort('amount') ?></th>
                <th><?= $this->Paginator->sort('unitQte') ?></th>
                <th><?= $this->Paginator->sort('unit') ?></th>
                <th><?= $this->Paginator->sort('product_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $str = strval($this->Paginator->counter());
                $number_page = intval($str[0]);
                foreach ($stocks as $key => $stock):
                    $numRow = ($numberRows*($number_page - 1)) + ($key+1); // Get numéro de row
            ?>
            <tr>
                <td><?= $numRow ?></td>
                <td><?= $this->Number->format($stock->amount) ?></td>
                <td><?= $this->Number->format($stock->unitQte) ?></td>
                <td><?= h($stock->unit) ?></td>
                <td><?= $this->Number->format($stock->product_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $stock->id], ['class' => 'btn btn-primary btn-md', 'escape' => false]) ?>
                    <?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['action' => 'edit', $stock->id], ['class' => 'btn btn-info btn-md', 'escape' => false]) ?>
                    <?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['action' => 'delete', $stock->id], ['class' => 'btn btn-danger btn-md', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $stock->id)]) ?>
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
