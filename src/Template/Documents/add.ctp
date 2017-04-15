<?=$this->assign('title', 'Documents');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('List Documents'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="documents form large-9 medium-8 columns content">
    <?= $this->Form->create($document, ['enctype' => 'multipart/form-data']) ?>
    <fieldset>
        <div class="block form-group">
            <legend><?= __('Ajouter Document') ?></legend>
            <div class="col-md-12 display-flex">
                    <div class="col-md-6 panel panel-default panel-border">
                        <div class="panel-heading">Inforamtions Générales</div>
                        <div class="panel-body">
                            <?php
                                

                                echo $this->Form->label('name', 'Nom du document', ['class' => 'label-style']);
                                echo $this->Form->input('name', ['id' => 'namedoc', 'label' => false, 'options' => $types_name, 'empty' => true, 'class'=>'input-style form-control', 'required' => true]);
                                echo $this->Form->label('version', 'version', ['class' => 'label-style']);
                                echo $this->Form->input('version', ['id' => 'versiondoc', 'options' => $version, 'empty' => true, 'label' => false, 'class'=>'input-style form-control']);
                                //Un autre input version_jq pour recuperer la valeur 1 obligatoire lorsque le select au dessus est disabled
                                echo $this->Form->input('version_jq', ['id' => 'version_jq', 'type' => 'hidden', 'value' => $id_client]);
                                //echo $this->Form->label('select_files', 'Dossier', ['class' => 'label-style']);
                                //echo $this->Form->input('file_id', ['type' => 'hidden', 'id' => 'FileIdSelect', '']);
                                echo $this->Form->input('document', ['id' => 'fileinput', 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text', 'required' => true]);
                                //echo $this->Form->label('path', 'Path', ['class' => 'label-style']);
                                //echo $this->Form->input('path', ['label' => false, 'class'=>'input-style form-control']);
                            ?>
                        </div>
                    </div>

                    <div class="col-md-6 panel panel-default panel-border">
                        <div class="panel-heading">Contact</div>
                        <div class="panel-body">
                            <?php
                                echo $this->Form->label('number_doc', 'Numéro du dossier', ['class' => 'label-style']);
                                echo $this->Form->input('number_doc', ['label' => false, 'class'=>'input-style form-control', 'value' => $number_doc, 'disabled' => true]); 
                                echo $this->Form->input('file_id', ['type' => 'hidden', 'value' => $id_file]);

                                echo $this->Form->label('clientid', 'Nom Client', ['class' => 'label-style']);
                                echo $this->Form->input('clientid', ['label' => false, 'type' => 'text', 'class'=>'input-style form-control', 'value' => $client_name, 'disabled' => true]);
                                echo $this->Form->input('client_id', ['type' => 'hidden', 'value' => $id_client]);
                                //echo $this->Form->label('file_id', 'Dossier', ['class' => 'label-style']);
                                //echo $this->Form->input('file_id', ['options' => $files, 'empty' => true, 'label' => false, 'class'=>'input-style form-control']);
                                echo $this->Form->label('type', 'type', ['class' => 'label-style']);
                                echo $this->Form->input('typeAffiche', ['options' => $types, 'id' => 'typedoc', 'label' => false, 'class'=>'input-style form-control', 'required' => true, 'disabled' => true, 'empty' => true]);
                                echo $this->Form->input('type', ['type' => 'hidden', 'id' => 'typeSend']);
                                
                            ?>
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
        echo "var typesreq_array = " . json_encode($types_req, JSON_FORCE_OBJECT) . ";";
        echo "var types_array = " . json_encode($types, JSON_FORCE_OBJECT) . ";";
        echo "initilizeAddDocPage();";
    $this->Html->scriptEnd();
?>
