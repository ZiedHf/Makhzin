<?=$this->assign('title', 'Types des documets');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Nouveau Type'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="requiredDocs index large-9 medium-8 columns content">
    <div class="nopadding panel panel-warning">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= __('Types des documents') ?></h3>
            <div class="pull-right addIndexInline">
                <?= $this->Html->link(__('<span class="glyphicon glyphicon-plus-sign"></span>'), ['action' => 'add'], ['escape' => false]) ?>
            </div>
        </div>
        <div class="panel-body">
            <table cellpadding="0" cellspacing="0" class="tab_width70 block_table table table-responsive">
                <thead>
                    <tr>
                        <th class="widthTh10">N°</th>
                        <th><?= $this->Paginator->sort('name', 'Nom Document') ?></th>
                        <th><?= $this->Paginator->sort('type', 'Type') ?></th>
                        <!--<th></?= $this->Paginator->sort('modified') ?></th>-->
                        <!--<th></?= $this->Paginator->sort('created') ?></th>-->
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $str = strval($this->Paginator->counter());
                        $number_page = intval($str[0]);
                        foreach ($requiredDocs as $key => $requiredDoc):
                            $numRow = ($numberRows*($number_page - 1)) + ($key+1); // Get numéro de row
                    ?>
                    <tr>
                        <td><?= $numRow ?></td>
                        <td><?= $this->Html->link(h($requiredDoc->name), ['action' => 'view', $requiredDoc->id], ['escape' => false]) ?></td>
                        <td><?= h($types[$requiredDoc->type]) ?></td>
                        <!--<td></?= h($requiredDoc->modified) ?></td>-->
                        <!--<td></?= h($requiredDoc->created) ?></td>-->
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $requiredDoc->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['action' => 'edit', $requiredDoc->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                            <!--?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['action' => 'delete', $requiredDoc->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $requiredDoc->id)]) ?-->
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
