<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Edit Zone'), ['action' => 'edit', $zone->id]) ?> </li>
        <!--li></?= $this->Form->postLink(__('Delete Zone'), ['action' => 'delete', $zone->id], ['confirm' => __('Are you sure you want to delete # {0}?', $zone->id)]) ?> </li-->
        <li><?= $this->Html->link(__('List Zones'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Zone'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="zones view large-9 medium-8 columns content">
    <div class="nopadding panel panel-default">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= h($zone->name) ?></h3>
        </div>
        <div class="panel-body">
            <table class="vertical-table table-viewVertical tab_width30">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($zone->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Crée par') ?></th>
                    <td><?= (isset($zone->users__created_by->username)) ? h($zone->users__created_by->username) : '-' ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Lots') ?></h4>
                <?php if (!empty($zone->lots)): ?>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th class="widthTh5"><?= __('N°') ?></th>
                        <th><?= __('Number') ?></th>
                        <th><?= __('File Id') ?></th>
                        <th><?= __('Client Id') ?></th>
                        <th><?= __('Product Id') ?></th>
                        <th><?= __('ExpectedQte') ?></th>
                        <th><?= __('Deadline') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php $i = 0; foreach ($zone->lots as $lots): $i++; ?>
                    <tr>
                        <td><?= h($i) ?></td>
                        <td><?= $this->Html->link(h($lots->number), ['controller' => 'Lots', 'action' => 'view', $lots->id], ['escape' => false]) ?></td>
                        <td><?= $this->Html->link(h($lotsInfo[$lots->id]['fileNum']), ['controller' => 'Files', 'action' => 'view', $lots->file_id], ['escape' => false]) ?></td>
                        <td><?= $this->Html->link(h($lotsInfo[$lots->id]['clientName']), ['controller' => 'Clients', 'action' => 'view', $lots->client_id], ['escape' => false]) ?></td>
                        <td><?= $this->Html->link(h($lotsInfo[$lots->id]['productName']), ['controller' => 'Products', 'action' => 'view', $lots->product_id], ['escape' => false]) ?></td>
                        <td><?= h($lots->expectedQte) ?></td>
                        <td><?= h($lots->deadline) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Lots', 'action' => 'view', $lots->id], ['class' => 'btn btn-primary btn-md', 'escape' => false]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', ['lot'])?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
