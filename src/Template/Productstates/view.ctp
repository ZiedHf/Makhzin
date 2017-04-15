<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Edit Productstate'), ['action' => 'edit', $productstate->id]) ?> </li>
        <!--li></?= $this->Form->postLink(__('Delete Productstate'), ['action' => 'delete', $productstate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productstate->id)]) ?> </li-->
        <li><?= $this->Html->link(__('List Productstates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Productstate'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Liste Produits'), ['controller' => 'products', 'action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="productstates view large-9 medium-8 columns content">
    <div class="nopadding panel panel-info">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= h($productstate->name) ?></h3>
        </div>
        <div class="panel-body">
            <table class="vertical-table table-viewVertical">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($productstate->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= h($productstate->users__created_by->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified By') ?></th>
                    <td><?= (isset($productstate->users__modified_by->username)) ? h($productstate->users__modified_by->username) : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($productstate->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($productstate->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
