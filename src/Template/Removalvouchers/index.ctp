<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <!--li></?= $this->Html->link(__('New Removalvoucher'), ['action' => 'add']) ?></li-->
    </ul>
</nav>
<div class="removalvouchers index large-9 medium-8 columns content">
    <div class="nopadding panel panel-warning">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= __('Removalvouchers') ?></h3>
            <div class="pull-right addIndexInline">
                <?= $this->Html->link(__('<span class="glyphicon glyphicon-plus-sign"></span>'), ['controller' => 'OutputSets', 'action' => 'chooseClient'], ['escape' => false]) ?>
            </div>
        </div>
        <div class="panel-body">
            <table cellpadding="0" cellspacing="0" class="tab_width60 block_table table table-responsive">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('number') ?></th>
                        <!--th></?= $this->Paginator->sort('id') ?></th-->
                        <th><?= $this->Paginator->sort('Date') ?></th>
                        <th><?= $this->Paginator->sort('created') ?></th>
                        <th><?= $this->Paginator->sort('created_by') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($removalvouchers as $removalvoucher): ?>
                    <tr>
                        <td><?= $this->Html->link(h($removalvoucher->number), ['controller' => 'OutputSets', 'action' => 'integrateOutput', $removalvoucher->id], ['target' => '_blank']) ?></td>
                        <td><?= h($removalvoucher->date_rv) ?></td>
                        <td><?= h($removalvoucher->created) ?></td>
                        <td><?= h($removalvoucher->users__created_by->username) ?></td>

                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'OutputSets', 'action' => 'integrateOutput', $removalvoucher->id], ['target' => '_blank', 'class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <?= $this->Html->link(__("<i class='fa fa-print action'></i>"), ['action' => 'printRemovalVoucher', $removalvoucher->id], ['target' => '_blank', 'class' => 'btn btn-default', 'escape' => false]) ?>
                            <!--/?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $removalvoucher->id], ['confirm' => __('Are you sure you want to delete # {0}?', $removalvoucher->id)]) ?-->
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
