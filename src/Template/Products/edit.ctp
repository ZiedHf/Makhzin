<?=$this->assign('title', 'Produits');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <!--li></?= $this->Form->postLink(
                __('Supprimer'),
                ['action' => 'delete', $product->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]
            )
        ?></li-->
        <li><?= $this->Html->link(__('Nouveau Produit'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvelle Categorie'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Stocks'), ['controller' => 'Stocks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="products form large-9 medium-8 columns content">
    <?= $this->Form->create($product, ['enctype' => 'multipart/form-data']) ?>
    <fieldset>
        <div class="nopadding panel panel-info">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Modifier Produit') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <div class="block form-group">
                        <div class="col-md-12 display-flex">
                            <div class="col-md-6 panel panel-default panel-border">
                                <div class="panel-heading">Inforamtions Produit</div>
                                <div class="panel-body">
                                    <?php
                                        echo $this->Form->input('name', ['label' => 'Nom Produit', 'class'=>'input-style form-control input-50']);
                                        echo $this->Form->input('productCode', ['label' => 'Code Produit', 'class'=>'input-style form-control input-50']);
                                        echo $this->Form->input('ngpCode', ['label' => 'NGP Code', 'class'=>'input-style form-control input-50']);
                                        echo $this->Form->input('barCode', ['label' => 'Code à bar', 'class'=>'input-style form-control input-50']);
                                        echo $this->Form->input('productState_id', ['label' => 'Etat', 'class'=>'input-style form-control input-50']);
                                        echo $this->Form->input('packaging_id', ['label' => 'Emballage', 'class'=>'input-style form-control input-50']);

                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6 panel panel-default panel-border">
                                <div class="panel-heading">Autre</div>
                                <div class="panel-body">
                                    <?php
                                        echo $this->Form->input('quota', ['id' => 'quotaId', 'label' => 'Quota', 'class'=>'input-style form-control input-30']);
                                        echo $this->Form->input('tolerance', ['id' => 'toleranceId', 'label' => 'Tolérance', 'class'=>'input-style form-control input-30']);
                                        echo $this->Form->input('subjectToQuota', ['id' => 'subjectToQuota', 'label' => 'Illimité']);
                                        echo $this->Form->input('approved', ['label' => 'Activé']);
                                        //echo $this->Form->input('unitQte', ['label' => 'UnitQte', 'class'=>'input-style form-control input-30']);
                                        echo $this->Form->input('unit', ['label' => 'Unité', 'class'=>'input-style form-control input-30']);
                                        echo $this->Form->input('zone_id', ['label' => 'Zone préférée', 'class'=>'input-style form-control input-50']);
                                    ?>
                                </div>
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
                                            <?php 
                                                foreach ($categories as $key => $value){
                                                    if(!in_array($key, $associations)){
                                            ?>
                                                        <option value="<?=$key;?>"><?=$value;?></option>
                                            <?php   }
                                                } 
                                            ?>
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
                                        <select name="with_quota[]" id="multi_d_to" class="form-control" size="5" multiple="multiple">
                                            <?php foreach ($categWithQuota as $key => $value){ ?>
                                                <option value="<?=$key;?>"><?=$value;?></option>
                                            <?php } ?>
                                        </select>

                                        <br/><hr/><br/>

                                        <b>Catégories sans quota</b>
                                        <select name="without_quota[]" id="multi_d_to_2" class="form-control" size="5" multiple="multiple">
                                            <?php foreach ($categWithoutQuota as $key => $value){ ?>
                                                <option value="<?=$key;?>"><?=$value;?></option>
                                            <?php } ?>
                                        </select>
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
                                <div class="panel-heading">Documents et description</div>
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <?php if($product->pic_path !== NULL){ ?>
                                        <?= $this->Html->image($this->Url->build(['controller' => 'Products',
                                                                            'action' => 'viewPic',
                                                                            $product->id
                                                                        ], true),
                                                ['class' => 'img-thumbnail img-responsive', 
                                                'style' => 'max-height:300px; margin-left: auto; margin-right: auto; display: block;']); 
                                        ?>
                                        <?php }else{ ?>
                                        <div class="panel panel-default">
                                            <div class="panel-body"><?=__('VideM', ['Image'])?></div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $this->Form->input('pic_path', ['id' => 'fileinput', 'label' => 'Image', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text']); ?>

                                        <?php 
                                            $disable = false; 
                                            if($product->pic_path === NULL) 
                                                $disable = true; 
                                        ?>
                                                <?= $this->Form->input('supp_pic', ['type' => 'checkbox', 'id' => 'supp_pic', 'label' => 'Supprimer l\'Image', 'value' => 1, 'disabled' => $disable]) ?>
                                    </div>
                                    <br>
                                    <hr>
                                    <br>
                                    <div class="col-md-6">
                                        <?php 
                                            $disableDoc = false; 
                                            if($product->doc_path !== NULL){ 
                                                echo 'Télécharger la pièce jointe : '.$this->Html->link(__('<i class="fa fa-file-text" aria-hidden="true"></i>'), ['controller' => 'Products', 'action' => 'viewDoc', $product->id], ['escape' => false]);
                                            }else{ 
                                                $disableDoc = true;  
                                        ?>
                                        <div class="panel panel-default">
                                            <div class="panel-body"><?=__('VideF', ['Pièce jointe'])?></div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6">
                                    <?= $this->Form->input('doc_path', ['id' => 'doc_path', 'label' => 'Pièce Jointe', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text']); ?>
                                    <?php 

                                        if($product->doc_path === NULL) 

                                    ?>
                                            <?= $this->Form->input('supp_doc', ['type' => 'checkbox', 'id' => 'supp_doc', 'label' => 'Supprimer le document', 'value' => 1, 'disabled' => $disableDoc]) ?>
                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <div class="alert alert-info" role="alert"> 
                                            - Choisissez un autre fichier si vous voulez changer l'ancien.<br>
                                            - Si vous voulez le supprimer, cochez le case de suppression.<br>
                                            - Ne changez pas les valeurs si vous ne voulez pas changer le fichier.
                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
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
        if($disable)
            echo "disable = 'true';";
        else
            echo "disable = 'false';";
        if($disableDoc)
            echo "disableDoc = 'true';";
        else
            echo "disableDoc = 'false';";
        echo "initializeEditProductPage();";
    $this->Html->scriptEnd();
?>
