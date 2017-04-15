<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <!--li></?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $zone->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $zone->id)]
            )
        ?></li-->
        <li><?= $this->Html->link(__('List Zones'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="zones form large-9 medium-8 columns content">
    <?= $this->Form->create($zone) ?>
    <fieldset>
        <div class="nopadding panel panel-default">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Edit Zone') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <?=  $this->Form->input('name', ['class'=>'input-20 input-style form-control', 'required' => true]); ?>
                </div>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button('Envoyer', ['id' => 'btnEnvoyer', 'type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
