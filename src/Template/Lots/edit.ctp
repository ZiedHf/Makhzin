<?=$this->assign('title', 'Lots');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <!--li></?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $lot->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $lot->id)]
            )
        ?></li-->
        <li><?= $this->Html->link(__('Liste Produits'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Produit'), ['controller' => 'Products', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Dossiers'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Dossier'), ['controller' => 'Files', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="lots form large-9 medium-8 columns content">
    <?= $this->Form->create($lot) ?>
    <fieldset>
        <div class="nopadding panel panel-warning">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Modification du Lot') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <div class="col-md-12 display-flex">
                        <div class="col-md-6 panel panel-default panel-border">
                            <div class="panel-heading">Informtions principales</div>
                            <div class="panel-body">
                                <?php
                                    echo $this->Form->label('number', 'Numéro du lot', ['class' => 'label-style']);
                                    echo $this->Form->input('number', ['label' => false, 'class'=>'input-style form-control input-50', 'disabled' => true]);

                                    echo $this->Form->label('referenceProvider', 'Réference Fournisseur', ['class' => 'label-style']);
                                    echo $this->Form->input('referenceProvider', ['label' => false, 'class'=>'input-style form-control input-50']);

                                    echo $this->Form->label('select_products', 'Liste des produits', ['class' => 'label-style']);
                                ?>
                                <br>
                                <select id="select_products" name="select_products" class="selectpicker show-tick show-menu-arrow width60" data-show-subtext="true" data-live-search="true" title="Liste des produits ..." disabled="disabled">
                                    <?php
                                    foreach ($products as $product) {
                                        if($lot['product_id'] == $product->id) $selected = 'selected';
                                        else $selected = '';
                                    ?>
                                        <option value="<?=$product->id?>" data-subtext="<?=$product->productCode?>" <?=$selected?>><?=$product->name?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                    //echo $this->Form->label('expectedQte', 'Quantité', ['class' => 'label-style']);
                                    //echo $this->Form->input('expectedQte', ['label' => false, 'class'=>'input-style form-control']);
                                    echo $this->Form->label('expectedQte', 'Quantité declaré', ['id' => 'expectedQteLabel', 'class' => 'label-style']);
                                    echo $this->Form->input('expectedQte', ['id' => 'expectedQte', 'label' => false, 'class'=>'input-style form-control input-30', 'empty' => true, 'required' => true]);
                                ?>
                                <div id="addAlertQuota"></div>    
                            </div>
                        </div>

                        <div class="col-md-6 panel panel-default panel-border">
                            <div class="panel-heading">Autre</div>
                            <div class="panel-body">
                                <?php

                                echo $this->Form->label('deadline', 'Délai Final', ['class' => 'label-style']);
                                    echo $this->Form->input('deadline', [ 'label' => false,
                                                                            'year' => [
                                                                                'class' => 'form-control',
                                                                            ],
                                                                            'month' => [
                                                                                'class' => 'form-control',
                                                                            ],
                                                                            'day' => [
                                                                                'class' => 'form-control',
                                                                            ]
                                                                        ]);

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
                                //echo $this->Form->label('actualQte', 'Quantité Actuelle', ['class' => 'label-style']);
                                //echo $this->Form->input('actualQte', ['label' => false, 'class'=>'input-style form-control']);

                                //echo $this->Form->input('product_id', ['options' => $products, 'empty' => true]);
                                echo $this->Form->input('product_id', ['type' => 'hidden', 'value' => $lot['product_id'], 'id' => 'ProductIdSelect']);



                                //echo $this->Form->label('client_id', 'Liste des clients', ['class' => 'label-style']);
                                //echo $this->Form->input('client_id', ['options' => $clients, 'empty' => true, 'label' => false, 'class'=>'input-style form-control']);
                                echo $this->Form->label('zone_id', 'Liste des zones', ['class' => 'label-style']);
                                echo $this->Form->input('zone_id', ['options' => $zones, 'empty' => true, 'label' => false, 'class'=>'input-style form-control input-40']);
                                //echo $this->Form->label('input_id', 'Liste des inputs', ['class' => 'label-style']);
                                //echo $this->Form->input('input_id', ['options' => $inputs, 'empty' => true, 'label' => false, 'class'=>'input-style form-control']);
                                //echo $this->Form->label('file_id', 'Liste des files', ['class' => 'label-style']);
                                //echo $this->Form->input('file_id', ['options' => $files, 'empty' => true, 'label' => false, 'class'=>'input-style form-control']);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    
    <div id="responsecontainer">
    
    </div><br>
    <!--</?= $this->Form->button(__('Submit')) ?>-->
    <?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>

<?php
    $this->Html->scriptStart(['block' => true]);
        echo "var products_array = " . json_encode($products, JSON_FORCE_OBJECT) . ";";
        echo "var racine_ajax = '".RACINE_AJAX."';";
        echo "initilizeEditLotPage();";
    $this->Html->scriptEnd();
?>
