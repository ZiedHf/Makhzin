<?=$this->assign('title', 'Dossiers');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Liste Dossiers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Fournisseurs'), ['controller' => 'Providers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Fournisseur'), ['controller' => 'Providers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="files form large-9 medium-8 columns content">
    <?= $this->Form->create($file) ?>
    <?php $this->Form->templates(['dateWidget' => '{{day}}{{month}}{{year}}']); ?>
    <fieldset>
        <div class="nopadding panel panel-warning">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Ajouter dossier') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <?php
                        echo $this->Form->label('number', 'Numéro du dossier', ['class' => 'label-style']);
                        echo $this->Form->input('number', ['label' => false, 'type' => 'text', 'value' => $number, 'disabled' => true, 'class'=>'input-style form-control input-30', 'empty' => true]); 
                        //echo $this->Form->text('client_mf', ['class' => 'users']);
                        echo $this->Form->label('select_clients', 'Entrepositaire', ['class' => 'label-style']);
                        echo $this->Form->input('client_id', ['type' => 'hidden', 'id' => 'ClientIdSelect', '']);
                    ?>
                        <select id="select_clients" class="selectpicker show-tick show-menu-arrow width30" data-show-subtext="true" data-live-search="true" title="Liste des entrepositaires ..." required>
                        <?php
                        foreach ($clients as $client) {
                        ?>
                            <option value="<?=$client->id?>" data-subtext="<?=$client->code?>"><?=$client->name?></option>
                        <?php
                        }
                        ?>
                        </select>



                    <div class="pull-left flex">
                        <table id="tableinfoclient" class="table pull-left tab_width50_left hidden">
                            <thead>
                                <tr><th>Nom Client</th><th>Code Client</th><th>Matricule Fiscale</th></tr>
                            </thead>
                            <tbody>
                                <tr><td id="NomClient"></td><td id="CodeClient"></td><td id="MFClient"></td></tr>
                            </tbody>
                        </table>    
                    </div>
                    <?php
                        echo $this->Form->label('select_providers', 'Fournisseur', ['class' => 'label-style']);
                        echo $this->Form->input('provider_id', ['type' => 'hidden', 'id' => 'ProviderIdSelect', '']);
                    ?>
                    <select id="select_providers" class="selectpicker show-tick show-menu-arrow width30" data-live-search="true" title="Liste des fournisseurs ...">
                    <?php
                        foreach ($providers as $provider) {
                    ?>
                            <option value="<?=$provider->id?>"><?=$provider->name?></option>
                    <?php
                        }
                    ?>
                    </select>
                    <?php
                        echo $this->Form->label('startDate', 'Date d\'arrivage', ['class' => 'label-style']);
                        echo $this->Form->input('startDate', [  'label' => false,
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
                                                                ]

                                                            ]);
                        //echo $this->Form->input('canceled');
                        //echo $this->Form->input('client_id', ['options' => $clients, 'empty' => true]); 

                    ?>

                    <?php
                        //echo $this->Form->input('input_id');
                    ?>
                </div>
            </div>
        </div>
    </fieldset>
    <!--</?= $this->Form->button(__('Submit')) ?>-->
    <?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
        
</div>
<?php
    $this->Html->scriptStart(['block' => true]);
        echo "var clients_array = " . json_encode($clients, JSON_FORCE_OBJECT) . ";";
        echo "var providers_array = " . json_encode($providers, JSON_FORCE_OBJECT) . ";";
        echo "initilizeAddFilePage();";
    $this->Html->scriptEnd();
?>