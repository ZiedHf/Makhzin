<?=$this->assign('title', 'Catégories');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
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
                <legend class="labelClass"><?= __('Ajouter Catégorie') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                    <div class="container">
                        <div class="block form-group">
                            <div class="col-md-12 display-flex">
                                <div class="col-md-6 panel panel-default panel-border">
                                    <div class="panel-heading">Inforamtions Catégorie</div>
                                    <div class="panel-body">
                                        <?php
                                            echo $this->Form->label('name', 'Nom Catégorie', ['class' => 'label-style']);
                                            echo $this->Form->input('name', ['label' => false, 'class'=>'input-style form-control input-40']);
                                            echo $this->Form->label('quota', 'Quota', ['class' => 'label-style']);
                                            echo $this->Form->input('quota', ['type' => 'number', 'step' => 'any', 'min' => '0', 'label' => false, 'class'=>'input-style form-control input-30', 'required' => true]);
                                            echo $this->Form->label('tolerance', 'Tolerance', ['class' => 'label-style']);
                                            echo $this->Form->input('tolerance', ['type' => 'number', 'step' => 'any', 'min' => '0', 'label' => false, 'class'=>'input-style form-control input-30']);
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-6 panel panel-default panel-border">
                                    <div class="panel-heading">Autre</div>
                                    <div class="panel-body">
                                        <?= $this->Form->label('description_categ', 'Description', ['class' => 'label-style']); ?>
                                        <?= $this->Form->input('description_categ', ['label' => false, 'rows' => '8', 'class'=>'form-control']);?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 display-flex">
                                    <div class="col-md-12 panel panel-default panel-border">
                                        <div class="panel-heading">Produits</div>
                                        <div class="panel-body">
                                            <div class="col-xs-5">
                                                <select name="from[]" id="multi_d" class="form-control" size="22" multiple="multiple">
                                                    <?php foreach ($products as $key => $value) { ?>
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
                                                <b>Produits avec quota</b>
                                                <select name="with_quota[]" id="multi_d_to" class="form-control" size="5" multiple="multiple"></select>

                                                <br/><hr/><br/>

                                                <b>Produits sans quota</b>
                                                <select name="without_quota[]" id="multi_d_to_2" class="form-control" size="5" multiple="multiple"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 display-flex">
                                    <div class="col-md-12 panel panel-default panel-border">
                                        <div class="panel-heading">Documents</div>
                                        <div class="panel-body">
                                            <div class="col-md-6">
                                                <?= $this->Form->input('pictogramme_path', ['id' => 'fileinput', 'label' => 'Pictogramme', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text']); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <?= $this->Form->input('doc_path', ['id' => 'piece_jointe', 'label' => 'Pièce-jointe 1', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text']); ?>
                                                <?= $this->Form->input('doc_path2', ['id' => 'piece_jointe_2', 'label' => 'Pièce-jointe 2', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text']); ?>
                                                <?= $this->Form->input('doc_path3', ['id' => 'piece_jointe_3', 'label' => 'Pièce-jointe 3', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text']); ?>
                                            </div>
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
        echo "initializeAddCategPage();";
    $this->Html->scriptEnd();
?>
