<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Edit Carrier'), ['action' => 'edit', $carrier->id]) ?> </li>
        <!--li></?= $this->Form->postLink(__('Delete Carrier'), ['action' => 'delete', $carrier->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carrier->id)]) ?> </li-->
        <li><?= $this->Html->link(__('List Carriers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carrier'), ['action' => 'add']) ?> </li>
        <!--li></?= $this->Html->link(__('List Inputs'), ['controller' => 'Inputs', 'action' => 'index']) ?> </li>
        <li></?= $this->Html->link(__('New Input'), ['controller' => 'Inputs', 'action' => 'add']) ?> </li>
        <li></?= $this->Html->link(__('List Removalvouchers'), ['controller' => 'Removalvouchers', 'action' => 'index']) ?> </li>
        <li></?= $this->Html->link(__('New Removalvoucher'), ['controller' => 'Removalvouchers', 'action' => 'add']) ?> </li-->
    </ul>
</nav>
<div class="carriers view large-9 medium-8 columns content">
    <div class="nopadding panel panel-success">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= h($carrier->name) ?></h3>
        </div>
        <div class="panel-body">
            <table class="vertical-table table-viewVertical">
                <tr>
                    <th><?= __('Raison sociale') ?></th>
                    <td><?= h($carrier->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Matricule Fiscale') ?></th>
                    <td><?= h($carrier->matriculeFiscale) ?></td>
                </tr>
                <tr>
                    <th><?= __('Adresse') ?></th>
                    <td><?= h($carrier->adresse) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tel') ?></th>
                    <td><?= h($carrier->tel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= h($carrier->users__created_by->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($carrier->created) ?></td>
                </tr>
                 <tr>
                    <th><?= __('Modified By') ?></th>
                    <td><?= h($carrier->users__modified_by->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($carrier->modified) ?></td>
                </tr>
            </table>
            <?php if(isset($carrier->text) && ($carrier->text != '')){ ?>
            <div>
                <h4><?= __('Description') ?></h4>
                <div class="alert alert-info" role="alert"><?= $this->Text->autoParagraph(h($carrier->text)); ?></div>
            </div>
            <?php } ?>
            <div class="related">
                <h4><?= __('Related Inputs') ?></h4>
                <?php if (!empty($carrier->inputs)): ?>

                <table cellpadding="0" cellspacing="0" class="tab_width50">
                    <tr>
                        <th class="widthTh10">N°</th>
                        <th><?= __('Date') ?></th>
                        <th><?= __('Created') ?></th>
                        <th><?= __('File Name') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php $i = 0; foreach ($carrier->inputs as $inputs): $i++; ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= h($inputs->date) ?></td>
                        <td><?= h($inputs->created) ?></td>
                        <td><?= h($files_nums[$inputs->file_id]) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Inputs', 'action' => 'view', $inputs->id], ['target' => '_blank', 'class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', [__('Related Inputs')])?></div>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Removalvouchers') ?></h4>
                <?php if(!empty($carrier->removalvouchers)): ?>

                <table cellpadding="0" cellspacing="0" class="tab_width80">
                    <tr>
                        <th class="widthTh10"><?= __('N°') ?></th>
                        <th><?= __('Number') ?></th>
                        <th><?= __('Entrepositaire') ?></th>
                        <th><?= __('Client') ?></th>
                        <th><?= __('Created') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php $i = 0; foreach($carrier->removalvouchers as $removalvouchers): $i++; ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= h($removalvouchers->number) ?></td>
                        <td><?= $clients_names[$removalvouchers-> entrepositaire_id] ?></td>
                        <td><?= $clients_names[$removalvouchers->client_id]?></td>
                        <td><?= h($removalvouchers->created) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'OutputSets', 'action' => 'integrateOutput', $removalvouchers->id], ['target' => '_blank', 'class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', [__('Related Removalvouchers')])?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

