<?=$this->assign('title', 'Clients');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Liste des entrepositaires'), ['action' => 'index', 1]) ?></li>
        <li><?= $this->Html->link(__('Liste des clients'), ['action' => 'index', 0]) ?></li>
        <li><?= $this->Html->link(__('Nouveau Client'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Dossiers'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Dossier'), ['controller' => 'Files', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="clients index large-9 medium-8 columns content">
    <div class="nopadding panel panel-success">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= __('Clients') ?></h3>
            <div class="pull-right addIndexInline">
                <?= $this->Html->link(__('<span class="glyphicon glyphicon-plus-sign"></span>'), ['action' => 'add'], ['escape' => false]) ?>
            </div>
        </div>
        <div class="panel-body">
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="widthTh5">N°</th>
                        <th><?= $this->Paginator->sort('name', 'Nom Client') ?></th>
                        <th><?= $this->Paginator->sort('matriculeFiscale', 'Matricule Fiscale') ?></th>
                        <th><?= $this->Paginator->sort('code', 'Code') ?></th>
                        <!--<th></?= $this->Paginator->sort('approved') ?></th>-->
                        <!--<th></?= $this->Paginator->sort('adress') ?></th>-->
                        <th><?= $this->Paginator->sort('email1', 'Email') ?></th>
                        <!--<th></?= $this->Paginator->sort('email2') ?></th>-->
                        <!--<th></?= $this->Paginator->sort('email3') ?></th>-->
                        <th><?= $this->Paginator->sort('tel1', 'Tel') ?></th>
                        <!--<th></?= $this->Paginator->sort('tel2') ?></th>-->
                        <!--<th></?= $this->Paginator->sort('tel3') ?></th>-->
                        <!--<th></?= $this->Paginator->sort('fax1') ?></th>-->
                        <!--<th></?= $this->Paginator->sort('fax2') ?></th>-->
                        <!--<th></?= $this->Paginator->sort('fax3') ?></th>-->
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $str = strval($this->Paginator->counter());
                        $number_page = intval($str[0]);
                        foreach ($clients as $key => $client):
                            //debug($client);die();
                            if($client->approved) $class = '';
                            else $class = 'alert-client';
                            $numRow = ($numberRows*($number_page - 1)) + ($key+1); // Get numéro de row
                    ?>
                    <tr class="<?=$class?>">
                        <td><?= $numRow ?></td>
                        <td><?= $this->Html->link(h($client->name), ['action' => 'view', $client->id], ['escape' => false]) ?></td>
                        <td><?= h($client->matriculeFiscale) ?></td>
                        <td><?= h($client->code) ?></td>
                        <!--<td></?= h($client->approved) ?></td>-->
                        <!--<td></?= h($client->adress) ?></td>-->
                        <td><?= h($client->email1) ?></td>
                        <!--<td></?= h($client->email2) ?></td>-->
                        <!--<td></?= h($client->email3) ?></td>-->
                        <td><?= h($client->tel1) ?></td>
                        <!--<td></?= h($client->tel2) ?></td>-->
                        <!--<td></?= h($client->tel3) ?></td>-->
                        <!--<td></?= h($client->fax1) ?></td>-->
                        <!--<td></?= h($client->fax2) ?></td>-->
                        <!--<td></?= h($client->fax3) ?></td>-->
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $client->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['action' => 'edit', $client->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                            <!--?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['action' => 'delete', $client->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $client->id)]) ?-->
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
