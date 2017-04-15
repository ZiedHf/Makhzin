<?=$this->assign('title', 'Bons de sortie');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Edit Output'), ['action' => 'edit', $output->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Output'), ['action' => 'delete', $output->id], ['confirm' => __('Are you sure you want to delete # {0}?', $output->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Outputs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Output'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lots'), ['controller' => 'Lots', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lot'), ['controller' => 'Lots', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Outputsets'), ['controller' => 'OutputSets', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Outputset'), ['controller' => 'OutputSets', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="outputs view large-9 medium-8 columns content">
    <h3><?= h($output->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Lot') ?></th>
            <td><?= $output->has('lot') ? $this->Html->link($output->lot->id, ['controller' => 'Lots', 'action' => 'view', $output->lot->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('File') ?></th>
            <td><?= $output->has('file') ? $this->Html->link($output->file->number, ['controller' => 'Files', 'action' => 'view', $output->file->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($output->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Qte') ?></th>
            <td><?= $this->Number->format($output->qte) ?></td>
        </tr>
        <tr>
            <th><?= __('OutpuSet Id') ?></th>
            <td><?= $this->Number->format($output->outputSet_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Date') ?></th>
            <td><?= h($output->date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($output->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($output->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Outputsets') ?></h4>
        <?php if (!empty($output->output_sets)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Date') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($output->output_sets as $outputsets): ?>
            <tr>
                <td><?= h($outputsets->id) ?></td>
                <td><?= h($outputsets->date) ?></td>
                <td><?= h($outputsets->created) ?></td>
                <td><?= h($outputsets->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'OutputSets', 'action' => 'view', $outputsets->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'OutputSets', 'action' => 'edit', $outputsets->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'OutputSets', 'action' => 'delete', $outputsets->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outputsets->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <div class="panel panel-default">
            <div class="panel-body"><?=__('VideM', ['groupement des bons de sortie'])?></div>
        </div>
        <?php endif; ?>
    </div>
</div>
