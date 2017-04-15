<?=$this->assign('title', 'Produits');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Nouveau Produit'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvelle Categorie'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="products index large-9 medium-8 columns content">
    <div class="nopadding panel panel-info">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= __('Produits') ?></h3>
            <div class="pull-right addIndexInline">
                <?= $this->Html->link(__('<span class="glyphicon glyphicon-plus-sign"></span>'), ['action' => 'add'], ['escape' => false]) ?>
            </div>
        </div>
        <div class="panel-body">
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="widthTh5">N°</th>
                        <th class="widthTh15"><?= $this->Paginator->sort('name', 'Nom') ?></th>
                        <th class="widthTh15"><?= $this->Paginator->sort('productCode', 'Code') ?></th>
                        <th class="widthTh15"><?= $this->Paginator->sort('ngpCode', 'NGP') ?></th>
                        <th class="widthTh10"><?= $this->Paginator->sort('quota') ?></th>
                        <th class="widthTh10"><?= $this->Paginator->sort('Stocks.amount', 'En stock') ?></th>
                        <th class="widthTh10"><?= $this->Paginator->sort('unit', 'Unité') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $str = strval($this->Paginator->counter());
                        $number_page = intval($str[0]);
                        foreach ($products as $key => $product):
                            if($product->approved) $class = '';
                            else $class = 'alert-product';
                            $numRow = ($numberRows*($number_page - 1)) + ($key+1); // Get numéro de row
                    ?>
                    <tr class="<?=$class?>">
                        <td><?= $numRow ?></td>
                        <td><?= $this->Html->link(h($product->name), ['action' => 'view', $product->id], ['escape' => false]) ?></td>
                        <td><?= h($product->productCode) ?></td>
                        <td><?= h($product->ngpCode) ?></td>
                        <!--<td></?= h($product->barCode) ?></td>-->
                        <!--<td></?= h($product->subjectToQuota) ?></td>-->
                        <td><?= ($product->quota === NULL) ? '-' : $this->Number->format($product->quota) ?></td>
                        <td><?= $this->Number->format($product->stock->amount) ?></td>
                        <!--<td></?= $this->Number->format($product->tolerance) ?></td>-->
                        <!--<td></?= h($product->approved) ?></td>-->
                        <!--<td></?= h($product->emballage) ?></td>-->
                        <!--<td></?= $this->Number->format($product->unitQte) ?></td>-->
                        <td><?= h($product->unit) ?></td>
                        <!--td></?= $this->Number->format($product->category_id) ?></td-->
                        <!--<td></?= $this->Number->format($product->stock_id) ?></td>-->
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $product->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['action' => 'edit', $product->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                            <!--?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['action' => 'delete', $product->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?-->
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
    </div>
</div>
