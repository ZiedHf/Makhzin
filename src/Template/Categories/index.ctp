<?=$this->assign('title', 'Catégories');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Nouvelle Categorie'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Produits'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Produit'), ['controller' => 'Products', 'action' => 'add']) ?></li>
    </ul>
</nav>

<div class="categories index large-9 medium-8 columns content">
    <div class="nopadding panel panel-info">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= __('Categories') ?></h3>
            <div class="pull-right addIndexInline">
                <?= $this->Html->link(__('<span class="glyphicon glyphicon-plus-sign"></span>'), ['action' => 'add'], ['escape' => false]) ?>
            </div>
        </div>
        <div class="panel-body">
            <table cellpadding="0" cellspacing="0" class="tab_width60">
                <thead>
                    <tr>
                        <th class="widthTh10">N°</th>
                        <th><?= $this->Paginator->sort('name', 'Nom Categorie') ?></th>
                        <th>Quota</th>
                        <th>En Stock</th>
                        <!--<th></?= $this->Paginator->sort('id') ?></th>
                        <th></?= $this->Paginator->sort('name') ?></th>
                        <th></?= $this->Paginator->sort('created') ?></th>
                        <th></?= $this->Paginator->sort('modified') ?></th>-->
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $str = strval($this->Paginator->counter());
                        $number_page = intval($str[0]);
                        foreach ($categories as $key => $category):
                            $numRow = ($numberRows*($number_page - 1)) + ($key+1); // Get numéro de row
                    ?>
                    <tr>
                        <td><?= h($numRow) ?></td>
                        <td><?= $this->Html->link(h($category->name), ['action' => 'view', $category->id], ['escape' => false]) ?></td>
                        <td><?= h($lesQuotaView[$category->id]) ?></td>
                        <td><?= h($amountView[$category->id]) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $category->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['action' => 'edit', $category->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                            <!--?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['action' => 'delete', $category->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?-->
                        </td>

                        <!--<td></?= $this->Number->format($category->id) ?></td>
                        <td></?= h($category->name) ?></td>
                        <td></?= h($category->created) ?></td>
                        <td></?= h($category->modified) ?></td>
                        <td class="actions">
                            </?= $this->Html->link(__('View'), ['action' => 'view', $category->id]) ?>
                            </?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id]) ?>
                            </?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?>
                        </td>-->
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
