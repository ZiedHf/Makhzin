<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $removalvoucher->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $removalvoucher->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Removalvouchers'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="removalvouchers form large-9 medium-8 columns content">
    <?= $this->Form->create($removalvoucher) ?>
    <fieldset>
        <legend><?= __('Edit Removalvoucher') ?></legend>
        <?php
            echo $this->Form->input('created_by');
            echo $this->Form->input('modified_by');
            echo $this->Form->input('number');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
