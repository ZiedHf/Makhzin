<?=$this->assign('title', 'Utilisateurs');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <div class="nopadding panel panel-danger">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= __('Users') ?></h3>
        </div>
        <div class="panel-body">
            <table cellpadding="0" cellspacing="0" class="tab_width50">
                <thead>
                    <tr>
                        <th class="widthTh5">N°</th>
                        <th><?= $this->Paginator->sort('username') ?></th>
                        <th class="widthTh20"><?= $this->Paginator->sort('role') ?></th>
                        <th class="widthTh10"><?= $this->Paginator->sort('enable', 'Activé') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $str = strval($this->Paginator->counter());
                        $number_page = intval($str[0]);
                        foreach ($users as $key => $user): 
                            $numRow = ($numberRows*($number_page - 1)) + ($key+1); // Get numéro de row
                            if($user->enable == 0){
                                $enable = 1;
                                $class = "<i class='color-green fa fa-unlock action'></i>";
                                $classLink = "btn btn-default btn-sm";
                                $actionEnable = "activer";
                            }else{
                                $enable = 0;
                                $class = "<i class='color-red fa fa-lock action'></i>";
                                $classLink = "btn btn-default btn-sm";
                                $actionEnable = "désactiver";
                            } 
                    ?>
                    <tr>
                        <td><?= $numRow ?></td>
                        <td><?= h($user->username) ?></td>
                        <td><?= h($user->role) ?></td>
                        <td><?= ($user->enable == 0) ? __('No') : __('Yes') ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['action' => 'view', $user->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['action' => 'edit', $user->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                            <?= $this->Form->postLink($class, ['action' => 'disableUser', $user->id, $enable], ['class' => $classLink, 'escape' => false, 'confirm' => __('Êtes vous sûr de vouloir désactivé cet utilisateur ?', [$actionEnable])]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                </ul>
                <p><?= $this->Paginator->counter('{{page}} sur {{pages}}') ?></p>
            </div>
        </div>
    </div>
</div>
