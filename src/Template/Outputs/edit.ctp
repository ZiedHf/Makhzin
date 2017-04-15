<?=$this->assign('title', 'Bons de sortie');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $output->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $output->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Outputs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lot'), ['controller' => 'Lots', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Outputsets'), ['controller' => 'OutputSets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Outputset'), ['controller' => 'OutputSets', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="outputs form large-9 medium-8 columns content">
    <?= $this->Form->create($output) ?>
    <fieldset>
        <legend><?= __('Edit Output') ?></legend>
        <?php
            echo $this->Form->input('date', ['empty' => true]);
            echo $this->Form->input('qte');
            echo $this->Form->input('lot_id', ['options' => $lots, 'empty' => true]);
            echo $this->Form->input('file_id', ['options' => $files, 'empty' => true]);
            echo $this->Form->input('outputSet_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
