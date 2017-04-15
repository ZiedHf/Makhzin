<?=$this->assign('title', 'Lots');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <!--li></?= $this->Html->link(__('Modifier Lot'), ['action' => 'edit', $lot->file->id, $lot->id]) ?> </li>
        <li></?= $this->Form->postLink(__('Supprimer Lot'), ['action' => 'delete', $lot->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lot->id)]) ?> </li-->
        <li><?= $this->Html->link(__('Liste Produits'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Produit'), ['controller' => 'Products', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Dossiers'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Dossier'), ['controller' => 'Files', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="lots view large-9 medium-8 columns content">
    <div class="nopadding panel panel-warning">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= h($lot->number) ?> (<?=$lotStat?>)</h3>
        </div>
        <div class="panel-body">
            <table class="vertical-table table-view">
                <tr>
                    <th><?= __('Number') ?></th>
                    <td><?= h($lot->number) ?></td>
                    <th><?= __('Product') ?></th>
                    <td><?= $lot->has('product') ? $this->Html->link($lot->product->name, ['controller' => 'Products', 'action' => 'view', $lot->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('ArrivalDate') ?></th>
                    <td><?= h($lot->file->startDate) ?></td>
                    <th><?= __('Deadline') ?></th>
                    <td><?= h($lot->deadline) ?></td>
                </tr>
                <tr>
                    <th><?= __('deadlineConsumption') ?></th>
                    <td><?= ($lot->deadlineConsumption !== Null) ? $lot->deadlineConsumption : '-' ?></td>
                    <th><?= __('referenceProvider') ?></th>
                    <td><?= ($lot->referenceProvider !== '') ? $lot->referenceProvider : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('ExpectedQte') ?></th>
                    <td><?= $this->Number->format($lot->expectedQte) ?></td>
                    <th><?= __('ActualQte') ?></th>
                    <td><?= $this->Number->format($lot->actualQte) ?></td>
                </tr>
                <tr>
                    <th><?= __('File') ?></th>
                    <td><?= $lot->has('file') ? $this->Html->link($lot->file->number, ['controller' => 'Files', 'action' => 'view', $lot->file->id]) : '' ?></td>
                    <th><?= __('Client') ?></th>
                    <td><?= $lot->has('client') ? $this->Html->link($lot->client->name, ['controller' => 'Clients', 'action' => 'view', $lot->client->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Input') ?></th>
                    <td><?= $lot->has('input') ? $this->Html->link($lot->input->id, ['controller' => 'Inputs', 'action' => 'view', $lot->input->id]) : '' ?></td>
                    <th><?= __('Zone') ?></th>
                    <td><?= $lot->has('zone') ? $this->Html->link($lot->zone->name, ['controller' => 'Zones', 'action' => 'view', $lot->zone->id]) : '' ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Outputs') ?></h4>
                <?php if (!empty($lot->outputs)): ?>
                <table cellpadding="0" cellspacing="0" class="tab_width80">
                    <tr>
                        <th><?= __('File Id') ?></th>
                        <th><?= __('Produit') ?></th>
                        <th><?= __('Qte') ?></th>
                        <th><?= __('OutpuSet Id') ?></th>
                        <th><?= __('Date') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($lot->outputs as $outputs): ?>
                    <tr>
                        <td><?= $lot->has('file') ? $this->Html->link($lot->file->number, ['controller' => 'Files', 'action' => 'view', $lot->file->id]) : '' ?></td>                
                        <td><?= $lot->has('product') ? $this->Html->link($lot->product->name, ['controller' => 'Products', 'action' => 'view', $lot->product->id]) : '' ?></td>
                        <td><?= h($outputs->qte) ?></td>
                        <td><?= ($outputs->outputSet_id) ? $this->Html->link('Voir groupement des bons de sortie', ['controller' => 'OutputSets', 'action' => 'view', $outputs->outputSet_id]) : '' ?></td>
                        <td><?= h($outputs->date) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Outputs', 'action' => 'view', $outputs->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <!--?= $this->Html->link(__('Edit'), ['controller' => 'Outputs', 'action' => 'edit', $outputs->id]) ?-->
                            <!--?= $this->Form->postLink(__('Delete'), ['controller' => 'Outputs', 'action' => 'delete', $outputs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outputs->id)]) ?-->
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', ['bon de sortie'])?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
