<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('New Carrier'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste des dossiers'), ['controller' => 'Files', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="carriers index large-9 medium-8 columns content">
    <div class="nopadding panel panel-success">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= __('Carriers') ?></h3>
            <div class="pull-right addIndexInline">
                <?= $this->Html->link(__('<span class="glyphicon glyphicon-plus-sign"></span>'), ['action' => 'add'], ['escape' => false]) ?>
            </div>
        </div>
        <div class="panel-body">
            <table cellpadding="0" cellspacing="0" class="tab_width80">
                <thead>
                    <tr>
                        <th class="widthTh5">N°</th>
                        <th><?= $this->Paginator->sort('name') ?></th>
                        <th><?= $this->Paginator->sort('matriculeFiscale', 'Matricule Fiscale') ?></th>
                        <th><?= $this->Paginator->sort('tel') ?></th>
                        <th><?= $this->Paginator->sort('created') ?></th>
                        <th><?= $this->Paginator->sort('created_by', __('createdBy')) ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $str = strval($this->Paginator->counter());
                        $number_page = intval($str[0]);
                        foreach ($carriers as $key => $carrier):
                            $numRow = ($numberRows*($number_page - 1)) + ($key+1); // Get numéro de row
                    ?>
                    <tr>
                        <td><?=$numRow?></td>
                        <td><?= $this->Html->link(h($carrier->name), ['action' => 'view', $carrier->id], ['escape' => false]) ?></td>
                        <td><?= h($carrier->matriculeFiscale) ?></td>
                        <td><?= h($carrier->tel) ?></td>
                        <td><?= h($carrier->created) ?></td>
                        <td><?= h($carrier->users__created_by->username) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $carrier->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['action' => 'edit', $carrier->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                            <!--?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $carrier->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carrier->id)]) ?-->
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
