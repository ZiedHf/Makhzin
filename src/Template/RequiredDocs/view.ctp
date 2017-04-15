<?=$this->assign('title', 'Types des documets');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Modifier Type Document'), ['action' => 'edit', $requiredDoc->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Supprimer Type Document'), ['action' => 'delete', $requiredDoc->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requiredDoc->id)]) ?> </li>
        <li><?= $this->Html->link(__('Liste Des Type Documents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Nouveau Type'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="requiredDocs view large-9 medium-8 columns content">
    <div class="nopadding panel panel-warning">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= h($requiredDoc->name) ?></h3>
        </div>
        <div class="panel-body">
            <table class="vertical-table table-view">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($requiredDoc->name) ?></td>
                    <th><?= __('Type') ?></th>
                    <td><?= h($types[$requiredDoc->type]) ?></td>
                </tr>
                <tr>
                    <th><?= __('Crée par') ?></th>
                    <td><?= (isset($requiredDoc->users__created_by->username)) ? h($requiredDoc->users__created_by->username) : '-' ?></td>
                    <th><?= __('Modifié par') ?></th>
                    <td><?= (isset($requiredDoc->users__modified_by->username)) ? h($requiredDoc->users__modified_by->username) : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($requiredDoc->modified) ?></td>
                    <th><?= __('Created') ?></th>
                    <td><?= h($requiredDoc->created) ?></td>
                </tr>

            </table>
        </div>
    </div>
</div>
