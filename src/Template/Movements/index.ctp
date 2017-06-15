<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?></li>
        <li><?= $this->Html->link(__('List Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="movements index large-9 medium-8 columns content">
    <div class="nopadding panel panel-warning">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= __('Movements') ?></h3>
        </div>
        <div class="panel-body">
            <table cellpadding="0" cellspacing="0" class="block_table table table-responsive">
                <thead>
                    <tr>
                        <th class="widthTh5">N°</th>
                        <th><?= $this->Paginator->sort('type', 'Type mouvement') ?></th>
                        <th><?= $this->Paginator->sort('Lots.number', 'Lot') ?></th>
                        <th><?= $this->Paginator->sort('stock_id', 'Produit') ?></th>
                        <th class="widthTh10"><?= $this->Paginator->sort('qte', 'Quantité') ?></th>
                        <th class="widthTh10"><?= $this->Paginator->sort('before_qte', 'Qte avant') ?></th>
                        <th class="widthTh10"><?= $this->Paginator->sort('after_qte', 'Qte Après') ?></th>
                        <th><?= $this->Paginator->sort('date') ?></th>
                        <th class="widthTh5"></th>
                        <!--th class="actions"></?= __('Actions') ?></th-->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $str = strval($this->Paginator->counter());
                        $number_page = intval($str[0]);
                        foreach ($movements as $key => $movement):
                            $numRow = ($numberRows*($number_page - 1)) + ($key+1); // Get numéro de row
                            if($movement->type == 0)
                                $typeMvt = "Mouvement entrant";
                            elseif($movement->type == 2)
                                $typeMvt = "Mouvement Sortant";
                            $product_id = $movement->stock->product_id;
                    ?>
                    <tr>
                        <td><?= $numRow ?></td>
                        <td><?= $typeMvt ?></td>
                        <td><?= $movement->has('lot') ? $this->Html->link($movement->lot->number, ['controller' => 'Lots', 'action' => 'view', $movement->lot->id]) : '' ?></td>
                        <td><?= $this->Html->link($products[$product_id], ['controller' => 'Products', 'action' => 'view', $product_id]) ?></td>
                        <td><?= $this->Number->format($movement->qte) ?></td>
                        <td><?= $this->Number->format($movement->before_qte) ?></td>
                        <td><?= $this->Number->format($movement->after_qte) ?></td>
                        <td><?= h($movement->date) ?></td>
                        <td><?= $movement->type == 0 ? '<i class="mvt-entrant fa fa-arrow-circle-left" aria-hidden="true"></i>' : '<i class="mvt-sortant fa fa-arrow-circle-right" aria-hidden="true"></i>' ?></td>
                        <!--td></?= h($movement->created) ?></td>
                        <td></?= h($movement->modified) ?></td>
                        <td></?= $movement->has('lot') ? $this->Html->link($movement->lot->id, ['controller' => 'Lots', 'action' => 'view', $movement->lot->id]) : '' ?></td>
                        <td class="actions">
                            </?= $this->Html->link(__('View'), ['action' => 'view', $movement->id]) ?>
                            </?= $this->Html->link(__('Edit'), ['action' => 'edit', $movement->id]) ?>
                            </?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $movement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $movement->id)]) ?>
                        </td-->
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
