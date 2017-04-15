<?=$this->assign('title', 'Lots');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Tous les lots'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Lots pas encore en stock'), ['action' => 'index', '0']) ?></li>
        <li><?= $this->Html->link(__('Lots pas encore sorti'), ['action' => 'index', '1']) ?></li>
        <li><?= $this->Html->link(__('Lots en cours de livraison'), ['action' => 'index', '2']) ?></li>
        <li><?= $this->Html->link(__('Lots terminés (Dossiers en stock)'), ['action' => 'index', '3']) ?></li>
        <li><?= $this->Html->link(__('Lots terminés (Dossiers livrés)'), ['action' => 'index', '4']) ?></li>
        <li><?= $this->Html->link(__('Liste Produits'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Produit'), ['controller' => 'Products', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Dossiers'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Dossier'), ['controller' => 'Files', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="lots index large-9 medium-8 columns content">
    <div class="nopadding panel panel-warning">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= __('Lots') ?></h3>
        </div>
        <div class="panel-body">
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="widthTh5">N°</th>
                        <th><?= $this->Paginator->sort('number') ?></th>
                        <!--<th></?= $this->Paginator->sort('arrivalDate') ?></th>-->
                        <th><?= $this->Paginator->sort('Files.number', 'Dossier') ?></th>
                        <th><?= $this->Paginator->sort('Files.statut', 'Statut dossier') ?></th>
                        <th><?= $this->Paginator->sort('Clients.name', 'Client') ?></th>
                        <th><?= $this->Paginator->sort('Products.name', 'Produit') ?></th>


                        <th><?= $this->Paginator->sort('expectedQte', 'Quantité déclaré') ?></th>
                        <th><?= $this->Paginator->sort('actualQte', 'Qte arrivée') ?></th>
                        <th><?= $this->Paginator->sort('remainedQte', 'Qte disponible') ?></th>
                        <th><?= $this->Paginator->sort('deadline') ?></th>
                        <!--<th></?= $this->Paginator->sort('zone_id') ?></th>-->
                        <!--<th></?= $this->Paginator->sort('input_id') ?></th>-->
                        <!--<th></?= $this->Paginator->sort('file_id') ?></th>-->
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $str = strval($this->Paginator->counter());
                        $number_page = intval($str[0]);
                        $i = 0;
                        foreach ($lots as $key => $lot):
                            $numRow = ($numberRows*($number_page - 1)) + ($key+1); // Get numéro de row
                    ?>
                    <tr>
                        <td><?= $numRow ?></td>
                        <td><?= $this->Html->link(h($lot->number), ['action' => 'view', $lot->id], ['escape' => false]) ?></td>
                        <!--<td></?= h($lot->arrivalDate) ?></td>-->
                        <td><?= $lot->has('file') ? $this->Html->link($lot->file->number, ['controller' => 'Files', 'action' => 'view', $lot->file->id]) : '' ?></td>
                        <td><?= $statuts[$lot->file->statut] ?></td>
                        <td><?= $lot->has('client') ? $this->Html->link($lot->client->name, ['controller' => 'Clients', 'action' => 'view', $lot->client->id]) : '' ?></td>
                        <td><?= $lot->has('product') ? $this->Html->link($lot->product->name, ['controller' => 'Products', 'action' => 'view', $lot->product->id]) : '' ?></td>


                        <td><?= $this->Number->format($lot->expectedQte) ?></td>
                        <td><?= ($lot->actualQte != -1) ? $this->Number->format($lot->actualQte) : 0; ?></td>
                        <td><?= $this->Number->format($lot->remainedQte) ?></td>
                        
                        <td><?= h($lot->deadline->format('d-m-Y')) ?></td>
                        <!--<td></?= $lot->has('zone') ? $this->Html->link($lot->zone->name, ['controller' => 'Zones', 'action' => 'view', $lot->zone->id]) : '' ?></td>-->
                        <!--<td></?= $lot->has('input') ? $this->Html->link($lot->input->id, ['controller' => 'Inputs', 'action' => 'view', $lot->input->id]) : '' ?></td>-->
                        <!--<td></?= $lot->has('file') ? $this->Html->link($lot->file->id, ['controller' => 'Files', 'action' => 'view', $lot->file->id]) : '' ?></td>-->
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $lot->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <!--?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['action' => 'edit', $lot->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?-->
                            <!--?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['action' => 'delete', $lot->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $lot->id)]) ?-->
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
