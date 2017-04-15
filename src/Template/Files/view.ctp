<?=$this->assign('title', 'Dossiers');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $file->statut == 0 ? $this->Html->link(__('Modifier Dossier'), ['action' => 'edit', $file->id]) : '' ?> </li>
        <li><?= $file->statut == 0 ? $this->Form->postLink(__('Supprimer Dossier'), ['action' => 'delete', $file->id], ['confirm' => __('Are you sure you want to delete # {0}?', $file->id)]) : ''?> </li>
        <li><?= $this->Html->link(__('Liste Dossiers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Nouveau Dossier'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Liste Clients'), ['controller' => 'Clients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Nouveau Client'), ['controller' => 'Clients', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Liste Lots'), ['controller' => 'Lots', 'action' => 'index']) ?> </li>
        <li><?= $file->statut == 0 ? $this->Html->link(__('Nouveau Lot'), ['controller' => 'Lots', 'action' => 'add', $file->id]) : '' ?> </li>
        <li><?= $this->Html->link('Nouveau bon à enlever', ['controller' => 'carriers', 'action' => 'selectCarriers', 0, 0, 'rv'], ['escape' => false]) ?></li>
    </ul>
</nav>
<div class="files view large-9 medium-8 columns content">
    <div class="nopadding panel panel-warning">
        <div class="panel-heading">
                <h3 class="indexH3Inline2"><?= h($file->number) ?> (<?=$statut?>)</h3>
                <div class="pull-right">
                    <!-- Standard button -->
                    <?php if(($file->statut != 2)&&($file->statut != 1)){ //Si n'est pas livré = afficher boutton verif ?>
                    <button id="btn-verification" type="button" class="btn btn-default">
                        <i class="button-fa fa fa-exclamation-circle" aria-hidden="true"></i>Détail
                    </button>
                    <?php } ?>
                    <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                    <?php if((empty($input))&&($file->statut != 3)&&(!empty($file->lots))){ ?>
                    <?= $this->Html->link(__("<i class='button-fa fa fa-file-text' aria-hidden='true'></i>Générer bon d'entrée ..."), 
                                            ['action' => 'validateActualQte', $file->id], 
                                            ['id' => 'generateInputBtn', 'class' => 'btn btn-primary', 
                                                'disabled' => 'disabled', 
                                                'escape' => false]) ?>

                    <?php }elseif(((empty($input))&&(($file->statut == 3)||(empty($file->lots))))){ ?>
                    <button type="button" class="btn btn-primary" disabled="disabled">
                        <i class="button-fa fa fa-file-text" aria-hidden="true"></i>Générer bon d'entrée ...
                    </button>
                    <?php }else{ ?>
                    <button type="button" class="btn btn-success" disabled="disabled">
                        <i class="button-fa fa fa-check-circle-o" aria-hidden="true"></i>Bon d'entrée généré
                    </button>
                    <?php } ?>
                </div>
        </div>
        <div class="panel-body">
            
            <div id="error">
                <?= (isset($msgError)) ? $msgError : "" ?>
            </div>
            <table class="vertical-table table-view">
                <tr>
                    <th><?= __('Numéro') ?></th>
                    <td><?= $file->number ?></td>
                    <th><?= __('Client') ?></th>
                    <td><?= $file->has('client') ? $this->Html->link($file->client->name, ['controller' => 'Clients', 'action' => 'view', $file->client->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Debut') ?></th>
                    <td><?= h($file->startDate->format('d-m-Y')) ?></td>
                    <th><?= __('Fournisseur') ?></th>
                    <td><?= $file->has('provider') ? $this->Html->link($file->provider->name, ['controller' => 'Providers', 'action' => 'view', $file->provider->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Crée par') ?></th>
                    <td><?= (isset($file->users__created_by->username)) ? h($file->users__created_by->username) : '-' ?></td>
                    <th><?= __('Modifié par') ?></th>
                    <td><?= (isset($file->users__modified_by->username)) ? h($file->users__modified_by->username) : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($file->created) ?></td>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($file->modified) ?></td>
                </tr>
            </table>
            <div id="ajaxTrait">
                <?php 
                        if(!empty($outdatedLots)){
                ?>

            <div id="verifLots" class="alert alert-warning" style="display:none;">
                <strong>Lots et Quota :</strong>
                        <table class="table-warning table table-hover">
                            <thead>
                              <tr>
                                <th>Numéro Lot</th>
                                <th>Produit</th>
                                <th>Quantité déclaré</th>
                                <th>Quantité arrivée</th>
                                <th>Espace Libre</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($outdatedLots as $key => $value){ 
                                        $idProduct = $value['product_id'];
                                ?>
                              <tr>
                                <td><?=$value['number']?></td>
                                <td><?=$products[$idProduct][0]['name']?></td>
                                <td><?=$value['expectedQte']?></td>
                                <td><?=($value['actualQte'] == -1) ? 0 : $value['actualQte']?></td>
                                <td>
                                    <?php 
                                        //if(($value['stockLibre'] < 0)&&($value['stockLibre'] != 'quotaNotConsidered'))
                                        if($value['stockLibre'] <= 0)
                                            echo 'Dépassé par : '. abs($value['stockLibre']); 
                                        elseif($value['stockLibre'] === 0)
                                            echo $value['stockLibre']; 
                                        //elseif($value['stockLibre'] == 'quotaNotConsidered')
                                        //    echo 'Quota non considéré'; 
                                        elseif($value['stockLibre'] === 'Null') // Produit n'a pas de seuil, illimité.
                                            echo 'Illimité';
                                        else
                                            echo $value['stockLibre'];
                                    ?>
                                </td>
                              </tr>
                              <?php } ?>
                            </tbody>
                        </table>
                    </div>

                <?php }elseif(empty($file->lots)){ ?>
                <!--Pas de lot-->
                <div id="verifLots" class="alert alert-danger" style="display:none;">
                    <strong>Lots et Quota :</strong>

                        Pas de lot !
                </div>    
                <?php }else{ ?>
                <!--Pas de problème-->
                <div id="verifLots" class="alert alert-success" style="display:none;">
                    <strong>Lots et Quota :</strong>

                        Aucun problème à signaler.
                </div>    
                <?php } ?>
                </div>
                <?php 
                    if(isset($fileMissing)){
                            if(count($fileMissing) > 0){
                ?>
                <div id="verifDocs" class="alert alert-warning" style="display:none;">
                    <strong>Les documents manquants :</strong>
                    <table class="table-warning table table-hover">
                        <thead>
                          <tr>
                            <th>Nom de dossier</th>
                            <th>Type</th>
                            <th>Date de création</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($fileMissing as $key => $value){ ?>
                          <tr>
                            <td><?=$value['name']?></td>
                            <td><?=$value['typeName']?></td>
                            <td><?=$value['modified']->format('d-m-Y')?></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                    </table>
                </div>
                    <?php }}else{ ?>
                    <div id="verifDocs" class="alert alert-success" style="display:none;">
                        <strong>Les documents :</strong>
                        Aucun problème à signaler.
                    </div>
                <?php } ?>

            <div class="related">
                <div class="add_block">
                    <div class="add_blockName" style=""><h4><?= __('Les Lots') ?></h4></div>
                    <?php if($file->statut == 0){ ?>
                    <div class="add_blockButton" style="">
                        <a href="<?=$this->Url->build(['controller' => 'Lots', 'action' => 'add', $file->id])?>">
                            <span class="glyphicon glyphicon-plus-sign"></span>
                        </a>
                    </div>
                    <?php } ?>
                </div>
                <?php if (!empty($file->lots)): ?>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th class="widthTh5"><?= __('N°') ?></th>
                        <th><?= __('N° Lot') ?></th>
                        <!--<th></?= __('ArrivalDate') ?></th>-->
                        <th><?= __('Produit') ?></th>
                        <th><?= __('Code Produit') ?></th>
                        <th><?= __('Ngp Code') ?></th>
                        <th><?= __('Qte déclarée') ?></th>
                        <th><?= __('ActualQte') ?></th>
                        <th><?= __('Qte disponible') ?></th>
                        <th><?= __('Date Finale') ?></th>
                        <!--<th></?= __('ExpectedQte') ?></th>-->


                        <!--<th></?= __('Client Id') ?></th>-->
                        <!--<th></?= __('Zone Id') ?></th>-->
                        <!--<th></?= __('Input Id') ?></th>-->
                        <!--<th></?= __('File Id') ?></th>-->
                        <th class="actions widthTh15"><?= __('Actions') ?></th>
                    </tr>
                    <?php 
                        $i = 0; 
                        foreach ($file->lots as $lots): 
                            $i++; 
                            if(!(($file->statut == 0) && ($lots->actualQte == -1))){
                                if($lots->expectedQte == $lots->actualQte){
                                    $icon = "<i class='fa fa-check-circle-o color-green' aria-hidden='true'></i>";
                                }else{
                                    $icon = "<i class='fa fa-exclamation-triangle color-red' aria-hidden='true'></i>";
                                }
                            }else $icon = "";

                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $this->Html->link(h($lots->number), ['controller' => 'Lots', 'action' => 'view', $lots->id], ['escape' => false]) ?></td>
                        <!--<td></?= h($lots->arrivalDate) ?></td>-->
                        <td><?= $this->Html->link(h($products[$lots->product_id][0]['name']), ['controller' => 'Products', 'action' => 'view', $lots->product_id]) ?></td>
                        <td><?= h($products[$lots->product_id][0]['productCode']) ?></td>
                        <td><?= h($products[$lots->product_id][0]['ngpCode']) ?></td>
                        <td><?= h($lots->expectedQte) ?></td>
                        <td id="TDactualQte_<?=$lots->id?>">
                            <!-- Button trigger modal -->
                            <?php 
                            if(($file->statut == 0) && ($lots->actualQte == -1)) 
                                echo $this->Form->button(__("<i class='fa fa-question-circle action' aria-hidden='true'></i>"), ['data-toggle' => 'modal', 'data-target' => '#IdLot_'.$lots->id, 'class' => 'btn btn-warning btn-sm', 'escape' => false]);
                            elseif($file->statut > 0)
                                echo h($lots->actualQte)." ".$icon;
                            else
                                echo $this->Html->link(__("<button type='button' class='btn btn-default' data-toggle='tooltip' data-placement='top' title='Cliquez pour modifier'>". h($lots->actualQte)." ".$icon ."</button>"),
                                        ['action' => '#'], 
                                        ['data-toggle' => 'modal', 'data-target' => '#IdLot_'.$lots->id, 'escape' => false]);
                            ?>
                        </td>
                        <td><?= h($lots->remainedQte) ?></td>
                        <td><?= h($lots->deadline->format('d-m-Y')) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Lots', 'action' => 'view', $lots->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <?= $file->statut == 0 ? $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['controller' => 'Lots', 'action' => 'edit',$file->id, $lots->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) : '' ?>
                            <?= $file->statut == 0 ? $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['controller' => 'Lots', 'action' => 'delete',$file->id, $lots->id, $products[$lots->product_id][0]['id']], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $lots->id)]) : '' ?>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', ['lot'])?></div>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <div class="add_block">
                    <div class="add_blockName" style=""><h4><?= __('Les Documents') ?></h4></div>
                    <?php if($file->statut == 0){ ?>
                    <div class="add_blockButton" style="">
                        <a href="<?=$this->Url->build(['controller' => 'Documents', 'action' => 'add', $file->id])?>">
                            <span class="glyphicon glyphicon-plus-sign"></span>
                        </a>
                    </div>
                    <?php } ?>
                </div>
                <?php if (!empty($file->documents)): ?>
                <table cellpadding="0" cellspacing="0" class="tab_width70">
                    <tr>
                        <th class="widthTh10"><?= __('N°') ?></th>
                        <th><?= __('Nom') ?></th>
                        <th><?= __('Type') ?></th>
                        <th><?= __('Version') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php 
                        $i= 0;
                        foreach ($file->documents as $documents): 
                            $i++;
                            if(($documents->type == '1')&&($documents->version == '0'))
                                $class = 'alert-doc';
                            else
                                $class = '';
                    ?>
                    <tr class="<?=$class;?>">
                        <td><?= $i ?></td>
                        <td><?= $this->Html->link(h($documents->name), ['controller' => 'Documents', 'action' => 'view', $documents->id], ['target' => '_blank', 'escape' => false]) ?></td>
                        <td><?= h($types[$documents->type]) ?></td>
                        <!--td></?php if($documents->version === '0') echo 'Copie'; elseif($documents->version == 1) echo 'Originale'; ?></td-->
                        <td><?= $documents['version'] === 0 ? 'Copie' : 'Originale' ?></td>
                        <td class="actions">
                            <!--?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), UPLOAD_FILE.$documents->path, ['class' => 'btn btn-primary btn-sm', 'target' => '_blank', 'escape' => false]) ?-->
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Documents', 'action' => 'view', $documents->id], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank', 'escape' => false]) ?>
                            <!--</?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['controller' => 'Documents', 'action' => 'edit', $documents->id], ['class' => 'btn btn-info btn-md', 'escape' => false]) ?>-->
                            <?= $file->statut == 0 ? $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['controller' => 'Documents', 'action' => 'delete', $documents->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $documents->id)]) : '' ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', ['document'])?></div>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <div class="add_block"><div class="add_blockName" style=""><h4><?= __('Bon d\'entrée') ?></h4></div></div>
                <?php if (!empty($input)): ?>
                <table class="tab_width30" cellpadding="0" cellspacing="0">
                    <tr>
                        <th><?= __('Date Création') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <tr>
                        <td><?= h($input->date->format('d-m-Y')) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Inputs', 'action' => 'view', $input->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <button class="btn btn-default" name="button" data-toggle="modal" data-target="#myModalCarriers">
                                <i class='fa fa-truck action'></i>
                            </button>
                        </td>
                    </tr>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', ['bon d\'entrée'])?></div>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <div class="add_block">
                    <div class="add_blockName" style=""><h4><?= __('Groupements des bons de sortie') ?></h4></div>
                    <?php 
                        if($file->statut == 1){ //Si le dossier est en stock on peut ajouter les bonds de sortie 
                            if($allLotsInOutput) $cantAddOutput = "cantAddOutput";
                            else $cantAddOutput = "";
                    ?>
                    <div class="add_blockButton" style="">
                        <a id="<?=$cantAddOutput?>" href="<?=$this->Url->build(['controller' => 'OutputSets', 'action' => 'add', $file->id])?>">
                            <span class="glyphicon glyphicon-plus-sign"></span>
                        </a>
                    </div>
                    <?php } ?>
                </div>

                <?php if (!empty($file->output_sets)): ?>
                <table class="tab_width40" cellpadding="0" cellspacing="0">
                    <tr>
                        <th><?= __('Created') ?></th>
                        <th><?= __('Statut') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($file->output_sets as $outputsets): ?>
                    <tr>
                        <td><?= h($outputsets->created) ?></td>
                        <td><?= h($statOutput[$outputsets->statut]) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'OutputSets', 'action' => 'view', $outputsets->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <?= ($outputsets->statut != 3  && $outputsets->statut != 1  && $file->statut != 2) ? $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['controller' => 'OutputSets', 'action' => 'edit', $outputsets->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) : '' ?>
                            <?= ($outputsets->statut != 3  && $outputsets->statut != 1 && $file->statut != 2) ? $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['controller' => 'OutputSets', 'action' => 'delete', $outputsets->id, $file->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $outputsets->id)]) : '' ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', ['Groupement des bons de sortie'])?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>




        <!-- Modal for lots -->
        <?php $i = 0; foreach ($file->lots as $lots): $i++; ?>
        <div class="modal fade bs-example-modal-sm" id="IdLot_<?=$lots->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Lot : <?=$lots->number?></h4>
              </div>
              <div class="modal-body">
                <?= $this->Form->create() ?>
                <!--?= $this->Form->label('number', 'Numéro du lot', ['class' => 'label-style']); ?>
                </?= $this->Form->input('number', ['label' => false, 'type' => 'text', 'value' => $lots->number, 'disabled' => true, 'class'=>'input-style form-control']) ?-->
                <?= $this->Form->label('product', 'Produit', ['class' => 'label-style']); ?>
                <?= $this->Form->input('product', ['label' => false, 'type' => 'text', 'value' => h($products[$lots->product_id][0]['name']), 'disabled' => true, 'class'=>'input-style form-control']) ?>
                <?= $this->Form->label('code_product', 'Code produit', ['class' => 'label-style']); ?>
                <?= $this->Form->input('code_product', ['label' => false, 'type' => 'text', 'value' => h($products[$lots->product_id][0]['productCode']), 'disabled' => true, 'class'=>'input-style form-control']) ?>
                <?= $this->Form->label('ngpCode', 'NGP Produit', ['class' => 'label-style']); ?>
                <?= $this->Form->input('ngpCode', ['label' => false, 'type' => 'text', 'value' => h($products[$lots->product_id][0]['ngpCode']), 'disabled' => true, 'class'=>'input-style form-control']) ?>
                <?= $this->Form->label('expectedQte', 'Qte déclarée', ['class' => 'label-style']); ?>
                <?= $this->Form->input('expectedQte', ['label' => false, 'type' => 'text', 'value' => h($lots->expectedQte), 'disabled' => true, 'class'=>'input-style form-control']) ?>
                <?= $this->Form->label('actualQte', 'Qte arrivée', ['class' => 'label-style']); ?>
                <?= $this->Form->input('actualQte', ['id' => 'actualQte'.$lots->id, 'min' => 0, 'value' => ($lots->actualQte == -1) ? $lots->expectedQte : $lots->actualQte, 'label' => false, 'type' => 'number', 'empty' => true, 'class'=>'input-style form-control']) ?>  
                <?= $this->Form->end() ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button onclick="updateActualQte(<?=$lots->id?>); updateWarningMsg(<?=$file->id?>);" type="button" class="btn btn-primary" data-dismiss="modal">Sauvegarder</button>
              </div>
            </div>
          </div>
        </div>

        <!--Modal Carriers-->
        <div class="modal fade" id="myModalCarriers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Transporteurs</h4>
              </div>
              <div id="modal-body" class="modal-body">

                <?php if(!empty($file->input->carriers)): ?>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th><?= __('Raison sociale') ?></th>
                        <th><?= __('Matricule Fiscale') ?></th>
                        <th><?= __('Tel') ?></th>
                    </tr>
                    <?php foreach ($file->input->carriers as $key => $value) { ?>
                    <tr>
                        <td><?= $this->Html->link(h($value->name), ['controller' => 'Carriers', 'action' => 'view', $value->id])?></td>
                        <td><?= h($value->matriculeFiscale) ?></td>
                        <td><?= h($value->tel) ?></td>
                    </tr>
                    <?php } ?>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', ['Transporteur'])?></div>
                </div>
                <?php endif; ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--button type="button" class="btn btn-primary">Save changes</button-->
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

<?php endforeach; ?>

<?php //echo $text;
    $this->Html->scriptStart(['block' => true]);
        echo "var racine_ajax = '".RACINE_AJAX."';";
        echo "initilizeViewFilePage();";
    $this->Html->scriptEnd();
?>
