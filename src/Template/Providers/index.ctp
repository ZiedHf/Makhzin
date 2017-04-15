<?=$this->assign('title', 'Fournisseurs');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Nouveau Fournisseur'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste des dossiers'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau dossier'), ['controller' => 'Files', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="providers index large-9 medium-8 columns content">
    <div class="nopadding panel panel-success">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= __('Fournisseurs') ?></h3>
            <div class="pull-right addIndexInline">
                <?= $this->Html->link(__('<span class="glyphicon glyphicon-plus-sign"></span>'), ['action' => 'add'], ['escape' => false]) ?>
            </div>
        </div>
        <div class="panel-body">
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="widthTh5">N°</th>
                        <th><?= $this->Paginator->sort('name', 'Nom') ?></th>
                        <th><?= $this->Paginator->sort('adress', 'Adresse') ?></th>
                        <th><?= $this->Paginator->sort('email') ?></th>
                        <th><?= $this->Paginator->sort('tel') ?></th>
                        <th><?= $this->Paginator->sort('fax') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $str = strval($this->Paginator->counter());
                        $number_page = intval($str[0]);
                        foreach ($providers as $key => $provider):
                            $numRow = ($numberRows*($number_page - 1)) + ($key+1); // Get numéro de row
                    ?>
                    <tr>
                        <td><?=$numRow?></td>
                        <td><?= $this->Html->link(h($provider->name), ['action' => 'view', $provider->id], ['escape' => false]) ?></td>
                        <td><?= h($provider->adress) ?></td>
                        <td><?= h($provider->email) ?></td>
                        <td><?= h($provider->tel) ?></td>
                        <td><?= h($provider->fax) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $provider->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['action' => 'edit', $provider->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                            <!--?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['action' => 'delete', $provider->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $provider->id)]) ?-->
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
