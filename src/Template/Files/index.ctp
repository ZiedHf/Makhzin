<?=$this->assign('title', 'Dossiers');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Tous les dossiers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Dossiers En Cours'), ['action' => 'index', 0]) ?></li>
        <li><?= $this->Html->link(__('Dossiers En Stock'), ['action' => 'index', 1]) ?></li>
        <li><?= $this->Html->link(__('Dossiers Livrés'), ['action' => 'index', 2]) ?></li>
        <li><?= $this->Html->link(__('Nouveau Dossier'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Fournisseurs'), ['controller' => 'Providers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Fournisseur'), ['controller' => 'Providers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="files index large-9 medium-8 columns content">
    <div class="nopadding panel panel-warning">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= __('Dossiers') ?></h3>
            <div class="pull-right addIndexInline">
                <?= $this->Html->link(__('<span class="glyphicon glyphicon-plus-sign"></span>'), ['action' => 'add'], ['escape' => false]) ?>
            </div>
        </div>
        <div class="panel-body">
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="widthTh5">N°</th>
                        <th><?= $this->Paginator->sort('number', 'Numéro') ?></th>
                        <th><?= $this->Paginator->sort('startDate', 'Date') ?></th>
                        <th><?= $this->Paginator->sort('statut') ?></th>
                        <th><?= $this->Paginator->sort('client_id', 'Client') ?></th>
                        <th><?= $this->Paginator->sort('provider_id', 'Fournisseur') ?></th>
                        <!--<th></?= $this->Paginator->sort('input_id') ?></th>-->
                        <th class="widthTh10"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $str = strval($this->Paginator->counter());
                        $number_page = intval($str[0]);
                        foreach ($files as $key => $file):
                            if($file->canceled) $class = 'alert-file';
                            else $class = '';
                            $idStatut = $file->statut;
                            $numRow = ($numberRows*($number_page - 1)) + ($key+1); // Get numéro de row
                    ?>
                    <tr class="<?=$class?>">
                        <td><?= $numRow ?></td>
                        <td><?= $this->Html->link(h($file->number), ['action' => 'view', $file->id]) ?></td>
                        <td><?= h($file->startDate->format('d-m-Y')) ?></td>
                        <td><?= h($statuts[$idStatut]) ?></td>
                        <td><?= $file->has('client') ? $this->Html->link($file->client->name, ['controller' => 'Clients', 'action' => 'view', $file->client->id]) : '' ?></td>
                        <td><?= $file->has('provider') ? $this->Html->link($file->provider->name, ['controller' => 'Providers', 'action' => 'view', $file->provider->id]) : '' ?></td>
                        <!--<td></?= $this->Number->format($file->input_id) ?></td>-->
                        <td>
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $file->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <?php // $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['action' => 'edit', $file->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                            <?= ($file->statut == 0) ? $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['action' => 'delete', $file->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $file->id)]) : '' ?>
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
