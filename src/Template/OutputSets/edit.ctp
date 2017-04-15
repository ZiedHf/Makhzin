<?=$this->assign('title', 'Bons à lever');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $outputset->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $outputset->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Outputsets'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="outputsets form large-9 medium-8 columns content">
    <?= $this->Form->create($outputset) ?>
    <fieldset>
        <div class="block form-group">
            <legend><?= __('Edit Outputset') ?></legend>
            <?php
                echo $this->Form->input('file_id', ['options' => $files, 'class'=>'input-style form-control input-20']);
                /*echo $this->Form->label('date', 'Date', ['class' => 'label-style']);
                echo $this->Form->input('date', ['empty' => true, 'label' => false,
                                                        'year' => [
                                                            'label' => 'Année',
                                                            'class' => 'form-control',
                                                        ],
                                                        'month' => [
                                                            'class' => 'form-control',
                                                            'data-type' => 'month',
                                                        ],
                                                        'day' => [
                                                            'class' => 'form-control',
                                                        ]]);*/
            ?>
        </div>
    </fieldset>
    <?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
