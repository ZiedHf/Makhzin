<?=$this->assign('title', 'Bons à lever');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <!--li></?= $this->Html->link(__('New Outputset'), ['action' => 'add']) ?></li-->
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <!--li></?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?></li-->
    </ul>
</nav>
<div class="outputsets index large-9 medium-8 columns content">
    <h3><?= __('Outputsets') ?></h3>
    <table cellpadding="0" cellspacing="0" class="block_table table table-responsive">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('N°') ?></th>
                <!--th></?= $this->Paginator->sort('Check') ?></th-->
                <th><?= $this->Paginator->sort('file_id') ?></th>
                <th><?= $this->Paginator->sort('date') ?></th>
                <!--th></?= $this->Paginator->sort('created') ?></th-->
                <!--th></?= $this->Paginator->sort('modified') ?></th-->
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <!--?= $this->Form->create(null, ['url' => ['controller' => 'OutputSets', 'action' => 'integrateOutput']]) ?-->
                <?php
                    $i = 0;
                    $str = strval($this->Paginator->counter());
                    $number_page = intval($str[0]);
                    foreach($outputsets as $key => $outputset):
                        $i++; 
                        $numRow = ($numberRows*($number_page - 1)) + ($key+1); // Get numéro de row
                ?>
                <tr>
                    <td><?= $numRow ?></td>
                    <!--td></?= $this->Form->input('test', ['type' => 'checkbox', 'name' => 'checkOutputSets[]', 'value' => $outputset->id, 'hiddenField' => false]) ?></td-->
                    <td><?= $outputset->has('file') ? $this->Html->link($outputset->file->number, ['controller' => 'Files', 'action' => 'view', $outputset->file->id]) : '' ?></td>
                    <td><?= h($outputset->date) ?></td>
                    <!--td></?= h($outputset->created) ?></td-->
                    <!--td></?= h($outputset->modified) ?></td-->
                    <td class="actions">
                        <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $outputset->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                        <!--?= $this->Html->link(__('Edit'), ['action' => 'edit', $outputset->id]) ?-->
                        <!--?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $outputset->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outputset->id)]) ?-->
                    </td>
                </tr>
                <?php endforeach; ?>
            
        </tbody>
    </table>
    <!--?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
    </?= $this->Form->end() ?-->
    <!--div class="paginator">
        <ul class="pagination">
            </?= $this->Paginator->prev('< ' . __('previous')) ?>
            </?= $this->Paginator->numbers() ?>
            </?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p></?= $this->Paginator->counter() ?></p>
    </div-->
</div>
