<?=$this->assign('title', 'Fournisseurs');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Modifier fournisseur'), ['action' => 'edit', $provider->id]) ?> </li>
        <!--li></?= $this->Form->postLink(__('Supprimer fournisseur'), ['action' => 'delete', $provider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $provider->id)]) ?> </li-->
        <li><?= $this->Html->link(__('Liste fournisseur'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Nouveau fournisseur'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Liste Dossiers'), ['controller' => 'Files', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Nouveau Dossier'), ['controller' => 'Files', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="providers view large-9 medium-8 columns content">
    <div class="nopadding panel panel-success">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= h($provider->name) ?></h3>
        </div>
        <div class="panel-body">
            <table class="vertical-table table-view">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($provider->name) ?></td>
                    <th><?= __('Adress') ?></th>
                    <td><?= h($provider->adress) ?></td>
                </tr>
                <tr>
                    <th><?= __('Website') ?></th>
                    <!--td></?= ($provider->website != Null || $this->website != '') ? $this->html->link((''), "http://www.google.com", ['escape' => false]) : '-' ?></td-->
                    <td><?= ($provider->website != Null || $provider->website != '') ? $this->html->link('<i class="fa fa-external-link" aria-hidden="true"></i>', $provider->website, ['escape' => false, 'target' => '_blank']) : '-' ?></td>
                    <th><?= __('Email') ?></th>
                    <td><?= h($provider->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tel') ?></th>
                    <td><?= h($provider->tel) ?></td>
                    <th><?= __('Fax') ?></th>
                    <td><?= h($provider->fax) ?></td>
                </tr>
                <tr>
                    <th><?= __('Crée par') ?></th>
                    <td><?= (isset($provider->users__created_by->username)) ? h($provider->users__created_by->username) : '-' ?></td>
                    <th><?= __('Modifié par') ?></th>
                    <td><?= (isset($provider->users__modified_by->username)) ? h($provider->users__modified_by->username) : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($provider->created->format('d-m-Y')) ?></td>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($provider->modified->format('d-m-Y')) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Dossiers') ?></h4>
                <?php if (!empty($provider->files)): ?>
                <table cellpadding="0" cellspacing="0" class="tab_width80">
                    <tr>
                        <th class="widthTh5"><?= __('N°') ?></th>
                        <th><?= __('Number') ?></th>
                        <th><?= __('Client Id') ?></th>
                        <th><?= __('Fournisseur') ?></th>
                        <th><?= __('StartDate') ?></th>
                        <th class="widthTh10"><?= __('Statut') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php $i = 0; foreach ($provider->files as $files): $i++; ?>
                    <tr>
                        <td><?= h($i) ?></td>
                        <td><?= $this->Html->link(h($files->number), ['controller' => 'Files', 'action' => 'view', $files->id]) ?></td>
                        <td><?= $this->Html->link(h($client_name[$files->client_id]), ['controller' => 'Clients', 'action' => 'view', $files->client_id]) ?></td>
                        <td><?= h($provider->name) ?></td>
                        <td><?= h($files->startDate) ?></td>
                        <td><?= h($statuts[$files->statut]) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Files', 'action' => 'view', $files->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
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
        </div>
    </div>
</div>
