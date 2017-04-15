<?=$this->assign('title', 'Catégories');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <!--li></?= $this->Form->postLink(
                __('Supprimer'),
                ['action' => 'delete', $category->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]
            )
        ?></li-->
        <li><?= $this->Html->link(__('Liste Categories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste Produits'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Produit'), ['controller' => 'Products', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="categories form large-9 medium-8 columns content">
    <?= $this->Form->create($category, ['enctype' => 'multipart/form-data']) ?>
    <fieldset>
        <div class="nopadding panel panel-info">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Modifier Catégorie') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <div class="block form-group">
                        <div class="col-md-12 display-flex">
                            <div class="col-md-6 panel panel-default panel-border">
                                <div class="panel-heading">Inforamtions Catégorie</div>
                                <div class="panel-body">
                                    <?php
                                        echo $this->Form->label('name', 'Nom Catégorie', ['class' => 'label-style']);
                                        echo $this->Form->input('name', ['label' => false, 'class'=>'input-style form-control input-40']);
                                        echo $this->Form->input('quota', ['label' => 'Quota Catégorie', 'value' => $quota, 'type' => 'number', 'step' => 'any', 'min' => '0', 'class'=>'input-style form-control input-50', 'required' => true]);
                                        echo $this->Form->input('tolerance', ['label' => 'Tolérance Catégorie', 'value' => $tolerance, 'type' => 'number', 'step' => 'any', 'min' => '0', 'class'=>'input-style form-control input-50']);
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-6 panel panel-default panel-border">
                                <div class="panel-heading">Autre</div>
                                <div class="panel-body">
                                    <?= $this->Form->label('description_categ', 'Description', ['class' => 'label-style']); ?>
                                    <?= $this->Form->input('description_categ', ['label' => false, 'rows' => '8', 'class'=>'form-control', 'required' => false]);?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 display-flex">
                                <div class="col-md-12 panel panel-default panel-border">
                                    <div class="panel-heading">Produits</div>
                                    <div class="panel-body">
                                        <div class="col-xs-5">
                                            <select name="from[]" id="multi_d" class="form-control" size="22" multiple="multiple">
                                                <?php 
                                                    foreach ($products as $key => $value){
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
                                            <b>Produits avec quota</b>
                                            <select name="with_quota[]" id="multi_d_to" class="form-control" size="5" multiple="multiple">
                                                <?php foreach ($prodWithQuota as $key => $value){ ?>
                                                    <option value="<?=$key;?>"><?=$value;?></option>
                                                <?php } ?>
                                            </select>

                                            <br/><hr/><br/>

                                            <b>Produits sans quota</b>
                                            <select name="without_quota[]" id="multi_d_to_2" class="form-control" size="5" multiple="multiple">
                                                <?php foreach ($prodWithoutQuota as $key => $value){ ?>
                                                    <option value="<?=$key;?>"><?=$value;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 display-flex">
                                <div class="col-md-12 panel panel-default panel-border">
                                    <div class="panel-heading">Documents</div>
                                    <div class="panel-body">
                                        <div class="col-md-6">
                                            <?php if($category->pictogramme_path !== NULL){ ?>
                                            <?= $this->Html->image($this->Url->build(['controller' => 'Categories',
                                                                                'action' => 'viewPic',
                                                                                $category->id
                                                                            ], true),
                                                    ['class' => 'img-thumbnail img-responsive', 
                                                    'style' => 'max-height:300px; margin-left: auto; margin-right: auto; display: block;']); 
                                            ?>
                                            <?php }else{ ?>
                                            <div class="panel panel-default">
                                                <div class="panel-body"><?=__('VideM', ['Pictogramme'])?></div>
                                            </div>
                                            <?php } ?>
                                            <?= $this->Form->input('pictogramme_path', ['id' => 'fileinput', 'label' => 'Pictogramme', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text']); ?>
                                            <?php 
                                                $disable = false; 
                                                if($category->pictogramme_path === NULL) 
                                                    $disable = true; 
                                            ?>
                                                    <?= $this->Form->input('supp_pic', ['type' => 'checkbox', 'id' => 'supp_pic', 'label' => 'Supprimer le pictogramme', 'value' => 1, 'disabled' => $disable]) ?>
                                        </div>
                                        
                                        <!--Les documents-->
                                        
                                        <div class="col-md-6">
                                            <?php 
                                                $disableDoc = false; 
                                                if($category->doc_path !== NULL){ 
                                                    echo 'Télécharger la pièce jointe : '.$this->Html->link(__('<i class="fa fa-file-text" aria-hidden="true"></i>'), ['controller' => 'Categories', 'action' => 'viewDoc', $category->id, 1], ['escape' => false]);
                                                }else{ 
                                                    $disableDoc = true;  
                                            ?>
                                            <div class="panel panel-default">
                                                <div class="panel-body"><?=__('VideF', ['Pièce jointe'])?></div>
                                            </div>
                                            <?php } ?>
                                            <?= $this->Form->input('doc_path', ['id' => 'doc_path', 'label' => 'Pièce Jointe 1', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text']); ?>
                                            <?= $this->Form->input('supp_doc', ['type' => 'checkbox', 'id' => 'supp_doc', 'label' => 'Supprimer le document', 'value' => 1, 'disabled' => $disableDoc]) ?>
                                            
                                            <!----><hr>
                                            
                                            <?php 
                                                $disableDoc2 = false; 
                                                if($category->doc_path2 !== NULL){ 
                                                    echo 'Télécharger la pièce jointe : '.$this->Html->link(__('<i class="fa fa-file-text" aria-hidden="true"></i>'), ['controller' => 'Categories', 'action' => 'viewDoc', $category->id, 2], ['escape' => false]);
                                                }else{ 
                                                    $disableDoc2 = true;  
                                            ?>
                                            <div class="panel panel-default">
                                                <div class="panel-body"><?=__('VideF', ['Pièce jointe'])?></div>
                                            </div>
                                            <?php } ?>
                                            <?= $this->Form->input('doc_path2', ['id' => 'doc_path2', 'label' => 'Pièce Jointe 2', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text']); ?>
                                            <?= $this->Form->input('supp_doc2', ['type' => 'checkbox', 'id' => 'supp_doc2', 'label' => 'Supprimer le document', 'value' => 1, 'disabled' => $disableDoc2]) ?>
                                            
                                            <!----><hr>
                                            
                                            <?php 
                                                $disableDoc3 = false; 
                                                if($category->doc_path3 !== NULL){ 
                                                    echo 'Télécharger la pièce jointe : '.$this->Html->link(__('<i class="fa fa-file-text" aria-hidden="true"></i>'), ['controller' => 'Categories', 'action' => 'viewDoc', $category->id, 3], ['escape' => false]);
                                                }else{ 
                                                    $disableDoc3 = true;  
                                            ?>
                                            <div class="panel panel-default">
                                                <div class="panel-body"><?=__('VideF', ['Pièce jointe'])?></div>
                                            </div>
                                            <?php } ?>
                                            <?= $this->Form->input('doc_path3', ['id' => 'doc_path3', 'label' => 'Pièce Jointe 3', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text']); ?>
                                            <?= $this->Form->input('supp_doc3', ['type' => 'checkbox', 'id' => 'supp_doc3', 'label' => 'Supprimer le document', 'value' => 1, 'disabled' => $disableDoc3]) ?>
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
        //Pictogramme
        if($disable)
            echo "disable = 'true';";
        else
            echo "disable = 'false';";
        //Doc1
        if($disableDoc)
            echo "disableDoc = 'true';";
        else
            echo "disableDoc = 'false';";
        //Doc2
        if($disableDoc2)
            echo "disableDoc2 = 'true';";
        else
            echo "disableDoc2 = 'false';";
        //Doc3
        if($disableDoc3)
            echo "disableDoc3 = 'true';";
        else
            echo "disableDoc3 = 'false';";
        echo "initializeEditCategPage();";
    $this->Html->scriptEnd();
?>
