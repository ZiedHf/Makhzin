<?=$this->assign('title', 'Bons d\'entrée');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $input->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $input->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Inputs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lot'), ['controller' => 'Lots', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="inputs form large-9 medium-8 columns content">
    <?= $this->Form->create($input) ?>
    <fieldset>
        <legend><?= __('Edit Input') ?></legend>
        <?php
            echo $this->Form->input('date', ['empty' => true]);
            echo $this->Form->input('file_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
