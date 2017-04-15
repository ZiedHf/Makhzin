<?=$this->assign('title', 'Produits');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Liste Produits'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvelle Categorie'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="products form large-9 medium-8 columns content">
    <?= $this->Form->create($product, ['enctype' => 'multipart/form-data']) ?>
    <fieldset>
        <div class="nopadding panel panel-info">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Ajouter Produit') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <div class="col-md-12 display-flex">
                        <div class="col-md-6 panel panel-default panel-border">
                            <div class="panel-heading">Inforamtions Produit</div>
                            <div class="panel-body">
                                <?php
                                    echo $this->Form->input('name', ['label' => 'Nom Produit', 'class'=>'input-style form-control input-50']);
                                    echo $this->Form->input('productCode', ['value' => $productCode, 'label' => 'Code Produit', 'class'=>'input-style form-control input-50', 'disabled' => true]);
                                    echo $this->Form->input('ngpCode', ['label' => 'NGP Code', 'class'=>'input-style form-control input-50']);
                                    echo $this->Form->input('barCode', ['label' => 'Code à bar', 'class'=>'input-style form-control input-50']);

                                    echo $this->Form->input('productState_id', ['label' => 'Etat', 'class'=>'input-style form-control input-50', 'empty' => true]);
                                    echo $this->Form->input('packaging_id', ['label' => 'Emballage', 'class'=>'input-style form-control input-50', 'empty' => true]);
                                    //echo $this->Form->input('approved', ['label' => 'Activé'])
                                ?>
                            </div>
                        </div>

                        <div class="col-md-6 panel panel-default panel-border">
                            <div class="panel-heading">Autre</div>
                            <div class="panel-body">
                                <?php
                                    echo $this->Form->input('quota', ['id' => 'quotaId', 'label' => 'Quota', 'class'=>'input-style form-control input-30']);
                                    echo $this->Form->input('tolerance', ['id' => 'toleranceId', 'label' => 'Tolérance', 'class'=>'input-style form-control input-30']);
                                    //echo $this->Form->input('quotaConsidered', ['label' => 'Quota Considéré']);
                                    echo $this->Form->input('subjectToQuota', ['id' => 'subjectToQuota', 'label' => 'Illimité', 'checked' => 'checked']);
                                    //echo $this->Form->input('emballage', ['label' => 'Emballage', 'class'=>'input-style form-control input-50']);
                                    //echo $this->Form->input('unitQte', ['label' => 'UnitQte', 'class'=>'input-style form-control input-30']);
                                    echo $this->Form->input('unit', ['label' => 'Unité', 'class'=>'input-style form-control input-30']);
                                    //if(isset()){
                                      //$  
                                    //}
                                    //echo $this->Form->input('category_id', ['label' => 'Categorie', 'empty' => true, 'value' => $idCat, 'class'=>'input-style form-control input-50', 'required' => true]);
                                    //echo $this->Form->input('stock_id', ['label' => 'Stock', 'class'=>'input-style form-control input-50']);
                                    echo $this->Form->input('zone_id', ['label' => 'Zone préférée', 'class'=>'input-style form-control input-50', 'empty' => true]);

                                ?>
                                <?php
                                    //Partie des catégories
                                    //echo $this->Form->label('categories', 'Categories');
                                ?>
                                <!--a href="#" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Pour sélectionner ou désélectioner des catégories. Appuyez sur CTRL et choisissez-les.">
                                    <i class="fa fa-question-circle-o"></i>
                                </a-->
                                <?php
                                    //echo $this->Form->input('categories._ids', ['label' => false, 'options' => $categories]);
                                ?>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="block form-group">
                    <div class="block form-group">
                        <div class="col-md-12 display-flex">
                            <div class="col-md-12 panel panel-default panel-border">
                                <div class="panel-heading">Catégories</div>
                                <div class="panel-body">
                                    <div class="col-xs-5">
                                        <select name="from[]" id="multi_d" class="form-control" size="22" multiple="multiple">
                                            <?php foreach ($categories as $key => $value) { ?>
                                                <option value="<?=$key;?>"><?=$value;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-2" style="margin: 20px 0 0 0">
                                        <!--button type="button" id="multi_d_rightAll" class="btn btn-default btn-block" style="margin-top: 20px;"><i class="glyphicon glyphicon-forward"></i></button-->
                                        <button type="button" id="multi_d_rightSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                        <button type="button" id="multi_d_leftSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                        <!--button type="button" id="multi_d_leftAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-backward"></i></button-->
                                        <hr style="margin: 115px 0 60px;" />

                                        <!--button type="button" id="multi_d_rightAll_2" class="btn btn-default btn-block"><i class="glyphicon glyphicon-forward"></i></button-->
                                        <button type="button" id="multi_d_rightSelected_2" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                        <button type="button" id="multi_d_leftSelected_2" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                        <!--button type="button" id="multi_d_leftAll_2" class="btn btn-default btn-block"><i class="glyphicon glyphicon-backward"></i></button-->
                                    </div>

                                    <div class="col-xs-5">
                                        <b>Catégories avec quota</b>
                                        <select name="with_quota[]" id="multi_d_to" class="form-control" size="5" multiple="multiple"></select>

                                        <br/><hr/><br/>

                                        <b>Catégories sans quota</b>
                                        <select name="without_quota[]" id="multi_d_to_2" class="form-control" size="5" multiple="multiple"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block form-group">
                    <div class="block form-group">
                        <div class="col-md-12 display-flex">
                            <div class="col-md-12 panel panel-default panel-border">
                                <div class="panel-heading">Détails</div>
                                <div class="panel-body">

                                    <div class="col-md-6">
                                        <?php
                                            //echo $this->Form->input('document', ['id' => 'fileinput', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text', 'required' => true]);
                                            echo $this->Form->input('pic_path', ['id' => 'fileinput', 'label' => 'Image', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text']);
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                            //echo $this->Form->input('document', ['id' => 'fileinput', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text', 'required' => true]);
                                            echo $this->Form->input('doc_path', ['id' => 'piece_jointe', 'label' => 'Pièce-jointe', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text']);
                                        ?>
                                    </div>
                                    <div class="col-md-12">
                                        <?= $this->Form->label('description_product', 'Description', ['class' => 'label-style']); ?>
                                        <?= $this->Form->input('description_product', ['label' => false, 'rows' => '8', 'class'=>'form-control']);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>

<?php
    $this->Html->scriptStart(['block' => true]);
        echo "initializeAddProductPage();";
    $this->Html->scriptEnd();
?>
