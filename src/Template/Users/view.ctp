<?=$this->assign('title', 'Utilisateurs');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?></li>
        <li><?= ($permissionLvl > 1) ? $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) : '' ?> </li>
        <li><?= ($id_user_view == $id_user_auth) ? $this->Html->link(__('Edit User password'), ['action' => 'editmyprofile', $user->id]) : '' ?></li>
        <li><?= ($permissionLvl > 1) ? $this->Html->link(__('List Users'), ['action' => 'index']) : '' ?> </li>
        <li><?= ($permissionLvl > 1) ? $this->Html->link(__('New User'), ['action' => 'add']) : '' ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <div class="nopadding panel panel-danger">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= h($user->username) ?></h3>
        </div>
        <div class="panel-body">
            <table class="vertical-table table-view tab_width50">
                <tr>
                    <th><?= __('Username') ?></th>
                    <td><?= h($user->username) ?></td>
                    <th><?= __('Role') ?></th>
                    <td><?= h($user->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Products') ?></th>
                    <td><?= $priv[$user->products] ?></td>
                    <th><?= __('Categories') ?></th>
                    <td><?= $priv[$user->categories] ?></td>
                </tr>
                <tr>
                    <th><?= __('Providers') ?></th>
                    <td><?= $priv[$user->providers] ?></td>
                    <th><?= __('Stocks') ?></th>
                    <td><?= $priv[$user->stocks] ?></td>
                </tr>
                <tr>
                    <th><?= __('Movements') ?></th>
                    <td><?= $priv[$user->movements] ?></td>
                    <th><?= __('Clients') ?></th>
                    <td><?= $priv[$user->clients] ?></td>
                </tr>
                <tr>
                    <th><?= __('Lots') ?></th>
                    <td><?= $priv[$user->lots] ?></td>
                    <th><?= __('Zones') ?></th>
                    <td><?= $priv[$user->zones] ?></td>
                </tr>
                <tr>
                    <th><?= __('Files') ?></th>
                    <td><?= $priv[$user->files] ?></td>
                    <th><?= __('Inputs') ?></th>
                    <td><?= $priv[$user->inputs] ?></td>
                </tr>
                <tr>
                    <th><?= __('Documents') ?></th>
                    <td><?= $priv[$user->documents] ?></td>
                    <th><?= __('OutputSets') ?></th>
                    <td><?= $priv[$user->outputSets] ?></td>
                </tr>
                <tr>
                    <th><?= __('Required Docs') ?></th>
                    <td><?= $priv[$user->required_docs] ?></td>
                    <th><?= __('Outputs') ?></th>
                    <td><?= $priv[$user->outputs] ?></td>
                </tr>
                <tr>
                    <th><?= __('Users') ?></th>
                    <td><?= $priv[$user->users] ?></td>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
