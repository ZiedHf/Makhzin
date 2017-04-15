<?=$this->assign('title', 'Clients');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Modifier Client'), ['action' => 'edit', $client->id]) ?> </li>
        <!--li></?= $this->Form->postLink(__('Supprimer Client'), ['action' => 'delete', $client->id], ['confirm' => __('Are you sure you want to delete # {0}?', $client->id)]) ?> </li-->
        <li><?= $this->Html->link(__('Liste Clients'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste Dossiers'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Dossier'), ['controller' => 'Files', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Lot'), ['controller' => 'Lots', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clients view large-9 medium-8 columns content">
    <div class="nopadding panel panel-success">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= h($client->name) ?></h3>
        </div>
        <div class="panel-body">
            <table class="vertical-table table-view">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($client->name) ?></td>
                    <th><?= __('MatriculeFiscale') ?></th>
                    <td><?= h($client->matriculeFiscale) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($client->code) ?></td>
                    <th><?= __('Adress') ?></th>
                    <td><?= h($client->adress) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email1') ?></th>
                    <td><?= h($client->email1) ?></td>
                    <th><?= __('Tel1') ?></th>
                    <td><?= h($client->tel1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email2') ?></th>
                    <td><?= h($client->email2) ?></td>
                    <th><?= __('Tel2') ?></th>
                    <td><?= h($client->tel2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email3') ?></th>
                    <td><?= h($client->email3) ?></td>
                    <th><?= __('Tel3') ?></th>
                    <td><?= h($client->tel3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fax1') ?></th>
                    <td><?= h($client->fax1) ?></td>
                    <th><?= __('Fax2') ?></th>
                    <td><?= h($client->fax2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fax3') ?></th>
                    <td><?= h($client->fax3) ?></td>
                    <th><?= __('Approved') ?></th>
                    <td><?= $client->approved ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Crée par') ?></th>
                    <td><?= (isset($client->users__created_by->username)) ? h($client->users__created_by->username) : '-' ?></td>
                    <th><?= __('Modifié par') ?></th>
                    <td><?= (isset($client->users__modified_by->username)) ? h($client->users__modified_by->username) : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($client->created) ?></td>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($client->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Les Dossiers') ?></h4>
                <?php if (!empty($client->files)): ?>
                <table cellpadding="0" cellspacing="0" class="tab_width70">
                    <tr>
                        <th class="widthTh5"><?= __('N°') ?></th>
                        <th><?= __('Numéro') ?></th>
                        <th><?= __('Client') ?></th>
                        <th><?= __('Fournisseur') ?></th>
                        <th><?= __('Date') ?></th>
                        <!--<th></?= __('Canceled') ?></th>-->
                        <!--<th></?= __('Client Id') ?></th>-->
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php $i = 0; foreach ($client->files as $files): $i++; ?>
                    <tr>
                        <td><?= h($i) ?></td>
                        <td><?= $this->Html->link(h($files->number), ['controller' => 'Files', 'action' => 'view', $files->id], ['escape' => false]) ?></td>
                        <td><?= h($client->name) ?></td>
                        <td><?= $this->Html->link(h($nameprovider[$files->id]), ['controller' => 'Providers', 'action' => 'view', $files->provider_id], ['escape' => false]) ?></td>
                        <td><?= h($files->startDate->format('d-m-Y')) ?></td>
                        <!--<td></?= h($files->canceled) ?></td>-->
                        <!--<td></?= h($files->client_id) ?></td>-->

                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Files', 'action' => 'view', $files->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <!--?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['controller' => 'Files', 'action' => 'edit', $files->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?-->
                            <!--?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['controller' => 'Files', 'action' => 'delete', $files->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $files->id)]) ?-->
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', ['dossier'])?></div>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Les Lots') ?></h4>
                <?php if (!empty($client->lots)): ?>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th class="widthTh5">N°</th>
                        <th><?= __('Numéro') ?></th>
                        <th><?= __('Dossier') ?></th>
                        <th><?= __('Produit') ?></th>
                        <th><?= __('Quantité') ?></th>

                        <!--<th></?= __('ArrivalDate') ?></th>-->


                        <th><?= __('ActualQte') ?></th>

                        <!--<th></?= __('Client Id') ?></th>-->
                        <!--<th></?= __('Zone Id') ?></th>-->
                        <!--<th></?= __('Input Id') ?></th>-->

                        <th><?= __('Date Finale') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php $i = 0; foreach ($client->lots as $lots): $i++; ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $this->Html->link(h($lots->number), ['controller' => 'Lots', 'action' => 'view', $lots->id], ['escape' => false]) ?></td>
                        <td><?= $this->Html->link(h($filesList[$lots->file_id]), ['controller' => 'Files', 'action' => 'view', $lots->file_id], ['escape' => false]) ?></td>
                        <td><?= $this->Html->link(h($productsList[$lots->product_id]), ['controller' => 'Products', 'action' => 'view', $lots->product_id], ['escape' => false]) ?></td>
                        <td><?= h($lots->expectedQte) ?></td>
                        <!--<td></?= h($lots->arrivalDate->format('d-m-Y')) ?></td>-->


                        <td><?= h($lots->actualQte) ?></td>

                        <!--<td></?= h($lots->client_id) ?></td>-->
                        <!--<td></?= h($lots->zone_id) ?></td>-->
                        <!--<td></?= h($lots->input_id) ?></td>-->

                        <td><?= h($lots->deadline->format('d-m-Y')) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Lots', 'action' => 'view', $lots->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <!--?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['controller' => 'Lots', 'action' => 'edit', $lots->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?-->
                            <!--?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['controller' => 'Lots', 'action' => 'delete', $lots->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $lots->id)]) ?-->
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', ['lot'])?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
