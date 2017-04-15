<?=$this->assign('title', 'Lots');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Retourner au dossier'), ['controller' => 'Files', 'action' => 'view', $id_doc]) ?> </li>
        <li><?= $this->Html->link(__('Liste Lot'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste Produits'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Produit'), ['controller' => 'Products', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Dossiers'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Dossier'), ['controller' => 'Files', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="lots form large-9 medium-8 columns content">
    
    <?= $this->Form->create($lot, ['id' => 'lotForm']) ?>
    <?php //$this->Form->templates(['dateWidget' => '{{day}}{{month}}{{year}}']); ?>
    <fieldset>
        <div class="nopadding panel panel-warning">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Ajouter Lot') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <div class="block form-group">
                        <div class="col-md-12 display-flex">
                            <div class="col-md-6 panel panel-default panel-border">
                                <div class="panel-heading">Informtions principales</div>
                                <div class="panel-body">
                                    <?php
                                        echo $this->Form->label('number', 'Numéro du lot', ['class' => 'label-style']);
                                        echo $this->Form->input('number', ['label' => false, 'class'=>'input-style form-control input-50', 'value' => $number, 'disabled' => true]);

                                        echo $this->Form->label('referenceProvider', 'Réference Fournisseur', ['class' => 'label-style']);
                                        echo $this->Form->input('referenceProvider', ['label' => false, 'class'=>'input-style form-control input-50']);

                                        echo $this->Form->label('select_products', 'Produit', ['class' => 'label-style']);
                                    ?>
                                    <br>
                                    <select id="select_products" class="selectpicker show-tick show-menu-arrow width60" data-show-subtext="true" data-live-search="true" title="Liste des produits ..." required>
                                        <?php
                                        foreach ($products as $product) {
                                        ?>
                                            <option value="<?=$product->id?>" data-subtext="<?=$product->productCode?>"><?=$product->name?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?php
                                        echo $this->Form->label('number_doc', 'Numéro du dossier', ['class' => 'label-style']);
                                        echo $this->Form->input('number_doc', ['label' => false, 'class'=>'input-style form-control input-50', 'value' => $number_doc, 'disabled' => true]); 
                                        echo $this->Form->input('file_id', ['type' => 'hidden', 'value' => $id_doc]); 
                                        //echo $this->Form->input('number');
                                        //echo $this->Form->input('arrivalDate', ['empty' => true]);
                                        //echo $this->Form->input('deadline', ['empty' => true]);
                                        echo $this->Form->label('clientid', 'Nom Client', ['class' => 'label-style']);
                                        echo $this->Form->input('clientid', ['label' => false, 'type' => 'text', 'class'=>'input-style form-control input-50', 'value' => $client_name, 'disabled' => true]);
                                        echo $this->Form->input('client_id', ['type' => 'hidden', 'value' => $id_client]);
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-6 panel panel-default panel-border">
                                <div class="panel-heading">Autre</div>
                                <div class="panel-body">
                                    <a id="addjoursBtn" data-toggle="collapse" data-target="#addjoursDiv"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                                    <?php
                                        echo $this->Form->label('deadline', 'Délai Final', ['class' => 'label-style']);

                                        echo $this->Form->input('deadline', [ 'label' => false,
                                                                            'year' => [
                                                                                'id' => 'deadlineYear', 
                                                                                'class' => 'form-control',
                                                                            ],
                                                                            'month' => [
                                                                                'id' => 'deadlineMonth', 
                                                                                'class' => 'form-control',
                                                                            ],
                                                                            'day' => [
                                                                                'id' => 'deadlineDay', 
                                                                                'class' => 'form-control',
                                                                            ]
                                                                        ]);
                                    ?>


                                    <div id="addjoursDiv" class="collapse">
                                        <?php
                                        echo $this->Form->input('datejours', ['id' => 'datejours', 'placeholder' => 'Jours', 'type' => 'number', 'label' => false, 'class'=>'input-style form-control input-15', 'empty' => true]); 
                                        ?>
                                    </div>
                                    <?php

                                        echo $this->Form->label('deadlineConsumption', 'Délai final de consommation', ['class' => 'label-style']);

                                        echo $this->Form->input('deadlineConsumption', [ 'label' => false,
                                                                            'year' => [
                                                                                'id' => 'consumptionYear', 
                                                                                'class' => 'form-control',
                                                                            ],
                                                                            'month' => [
                                                                                'id' => 'consumptionMonth', 
                                                                                'class' => 'form-control',
                                                                            ],
                                                                            'day' => [
                                                                                'id' => 'consumptionDay', 
                                                                                'class' => 'form-control',
                                                                            ]
                                                                        ]);

                                        echo $this->Form->label('expectedQte', 'Quantité', ['id' => 'expectedQteLabel', 'class' => 'label-style']);
                                        echo $this->Form->input('expectedQte', ['id' => 'expectedQte', 'label' => false, 'class'=>'input-style form-control input-30', 'empty' => true, 'required' => true]);
                                    ?>
                                    <div id="addAlertQuota"></div>    
                                    <?php
                                        //echo $this->Form->input('expectedQte');
                                        //echo $this->Form->label('actualQte', 'Quantité Actuelle (Kg)', ['class' => 'label-style']);
                                        //echo $this->Form->input('actualQte', ['label' => false, 'class'=>'input-style form-control input-30', 'empty' => true]);
                                        //echo $this->Form->input('actualQte');

                                        echo $this->Form->input('product_id', ['type' => 'hidden', 'id' => 'ProductIdSelect']);

                                        //echo $this->Form->input('product_id', ['options' => $products, 'empty' => true]);
                                        echo $this->Form->label('zone_id', 'Zone', ['class' => 'label-style']);
                                        echo $this->Form->input('zone_id', ['id' => 'input_zoneId', 'options' => $zones, 'label' => false, 'class'=>'input-style form-control input-50', 'empty' => true]);
                                        //echo $this->Form->input('input_id', ['options' => $inputs, 'label' => false, 'class'=>'input-style form-control', 'empty' => true]);
                                        //echo $this->Form->input('file_id', ['options' => $files, 'empty' => true]);
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    
    <div id="responsecontainer">
    
    </div><br>
    <div id="sendBtnDiv">
        <!--?= $this->Form->button('Envoyer', ['id' => 'btnEnvoyer', 'type' => 'submit', 'class' => 'btn btn-primary hidden']); ?-->
        <?= $this->Form->button('Envoyer', ['id' => 'btnEnvoyer', 'type' => 'submit', 'class' => 'btn btn-primary']); ?>
    </div>
    <?= $this->Form->end() ?>
    
    
</div>

<?php //die(RACINE_AJAX);
    $this->Html->scriptStart(['block' => true]);
        echo "var products_array = " . json_encode($products, JSON_FORCE_OBJECT) . ";";
        echo "var racine_ajax = '".RACINE_AJAX."';";
        echo "initilizeAddLotPage();";
    $this->Html->scriptEnd();
?>
