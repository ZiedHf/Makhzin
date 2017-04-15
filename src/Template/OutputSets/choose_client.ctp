<?=$this->assign('title', 'Dossiers');?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Liste Dossiers'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Fournisseurs'), ['controller' => 'Providers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Fournisseur'), ['controller' => 'Providers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="files form large-9 medium-8 columns content">
    <fieldset>
        
        <div class="nopadding panel panel-warning">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Création d\'un bon à enlever') ?></legend>
            </div>
            <div class="panel-body">
                <?= $this->Form->create() ?>
                <?php $this->Form->templates(['dateWidget' => '{{day}}{{month}}{{year}}']); ?>
                    <?php if($error){ ?>
                        <br>
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?=$errorMsg?>
                        </div>
                    <?php } ?>



                    <div class="block form-group">
                        <br>
                        <select id="select_client" class="selectpicker show-tick show-menu-arrow width30" data-show-subtext="true" data-live-search="true" title="Liste des entrepositaires ..." required>
                        <?php
                        foreach ($clients as $client) {
                        ?>
                            <option value="<?=$client->id?>" data-subtext="<?=$client->code?>" <?php  if($client->id == $id_client) echo "selected"; ?> ><?=$client->name?></option>
                        <?php
                        }
                        ?>
                        </select>

                    </div>

                    <div class="block form-group">   
                        <select id="select_client2" class="selectpicker show-tick show-menu-arrow width30" data-show-subtext="true" data-live-search="true" title="Liste des clients ..." required>
                            <?php
                            foreach ($clients2 as $client) {
                            ?>
                                <option value="<?=$client->id?>" data-subtext="<?=$client->code?>" <?php  if($client->id == $id_client2) echo "selected"; ?> ><?=$client->name?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <?php
                        echo $this->Form->label('date_rv', 'Date', ['class' => 'label-style']);
                        echo $this->Form->input('date_rv', ['type' => 'date',  'label' => false,
                                                                'year' => [
                                                                    'id' => 'yearid',
                                                                    'label' => 'Année',
                                                                    'class' => 'form-control',
                                                                ],
                                                                'month' => [
                                                                    'id' => 'monthid',
                                                                    'class' => 'form-control',
                                                                    'data-type' => 'month',
                                                                ],
                                                                'day' => [
                                                                    'id' => 'dayid',
                                                                    'class' => 'form-control',
                                                                ]

                                                            ]);
                    ?>
                    <br>
                <?= $this->Form->end() ?>
                <div id="responsecontainer"></div>
            </div>
        </div>
        
    </fieldset>
    <!--</?= $this->Form->button(__('Submit')) ?>-->
    
    
</div>



<?php
    $this->Html->scriptStart(['block' => true]);
        //echo "var clients_array = " . json_encode($clients, JSON_FORCE_OBJECT) . ";";
        //echo "var providers_array = " . json_encode($providers, JSON_FORCE_OBJECT) . ";";
        echo "var racine_ajax = '".RACINE_AJAX."';";
        echo "var id_client ='".$id_client."';";
        echo "var id_client2 ='".$id_client2."';";
        echo "var carriers ='".$carriers."';";
        echo "initilizeChooseClientPage();";
    $this->Html->scriptEnd();
?>