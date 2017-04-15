<?=$this->assign('title', 'Bons de sortie');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Retourner au dossier'), ['controller' => 'Files', 'action' => 'view', $idFile]) ?> </li>
    </ul>
</nav>
<div class="outputs form large-9 medium-8 columns content">
    <?= $this->Form->create($output) ?>
    <fieldset>
        <div class="block form-group">
            <div class="block form-group">
                <legend><?= __('Ajouter un bon de sortie') ?></legend><br>
                <?php
                    echo $this->Form->input('number_file', ['label' => 'Numéro du dossier', 'class'=>'input-style form-control input-20', 'value' => $file['number'], 'disabled' => true]); 
                    //echo $this->Form->input('date', ['empty' => true]);
                    //echo $this->Form->input('qte');
                    //echo $this->Form->input('date', ['value' => $outputset['date']]);
                    /*echo $this->Form->label('date', 'Date');
                    echo $this->Form->input('date', ['year' => ['id' => 'deadlineYear', 
                                                            'class' => 'form-control',
                                                        ],
                                                        'month' => [
                                                            'id' => 'deadlineMonth', 
                                                            'class' => 'form-control',
                                                        ],
                                                        'day' => [
                                                            'id' => 'deadlineDay', 
                                                            'class' => 'form-control',
                                                        ],
                                                        'value' => $outputset['date'],
                                                        'label' => false
                                                    ]);
                    */
                    
                    echo $this->Form->input('outputSet_id', ['type' => 'hidden', 'value' => $outputset['id']]);    
                    //echo $this->Form->input('lot_id', ['options' => $lots, 'empty' => true]);
                    //echo $this->Form->input('file_id', ['options' => $files, 'value' => $idFile, 'disabled' => true]);
                    echo $this->Form->label('select_lots', 'Lots', ['class' => 'label-style']);
                ?>
                <select id="select_lots" class="selectpicker show-tick show-menu-arrow width30" data-show-subtext="true" data-live-search="true" title="Liste des lots ..." required>
                    <?php
                    foreach ($lots as $lot) {
                    ?>
                        <option value="<?=$lot->id?>" data-subtext="<?=$lot->product_name?>"><?=$lot->number?></option>
                    <?php
                    }
                    ?>
                </select><br>

                <?php
                    echo $this->Form->input('qte', ['id' => 'qte', 'type' => 'number', 'min' => 0,'label' => 'Quantité', 'class'=>'input-style form-control input-10', 'empty' => true, 'required' => true]);
                    echo $this->Form->input('lot_id', ['type' => 'hidden', 'id' => 'LotIdSelect']);
                    echo $this->Form->input('file_id', ['type' => 'hidden', 'value' => $idFile]);
                    
                    echo $this->Form->input('maxQte', ['id' => 'maxQte', 'type' => 'hidden']);
                    //echo $this->Form->input('outpuSet_id');
                ?>
                <div id="addQuantite" class="width20per"></div>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button('Envoyer', ['id' => 'btnEnvoyer', 'type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
<?php //echo $text;
    $this->Html->scriptStart(['block' => true]);
        echo "var lots_array = " . json_encode($lots, JSON_FORCE_OBJECT) . ";";
        echo "initilizeAddOutputPage();";
    $this->Html->scriptEnd();
?>