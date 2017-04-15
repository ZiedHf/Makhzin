<?=$this->assign('title', 'Bons à lever');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Retourner au dossier'), ['controller' => 'Files', 'action' => 'view', $outputset->file_id]) ?> </li>
        <!--li></?= ($outputset->statut != 0) ?  $this->Html->link(__('Imprimer'), ['action' => 'printOutputset', $outputset->id], ['target' => '_blank']) : '' ?></li-->
    </ul>
</nav>
<div class="outputsets view large-9 medium-8 columns content">
    
    <div class="nopadding panel panel-warning">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= h("Groupement des bons de sortie (".$arraySatut[$outputset->statut].")")?></h3>
            <div class="pull-right">
                <?php if($outputset->statut == 0){ ?>
                <button id="btn-verification" type="button" class="btn btn-default">
                    <i class="button-fa fa fa-exclamation-circle" aria-hidden="true"></i>Lots à ajouter
                </button>
                <?php } ?>
                <?php if(($outputset->statut == 0)&&(!empty($outputset->outputs))){ // OutputSet en cours et il l'a des outputs, on peut valider ?>
                <?= $this->Html->link(__("<i class='button-fa fa fa-file-text' aria-hidden='true'></i> Valider"), ['controller' => 'OutputSets', 'action' => 'firstValidation', $outputset->id], ['class' => 'btn btn-primary', 'escape' => false, 'confirm' => __('Êtes vous sûr de vouloir valider le groupement des bons de sortie ?')]) ?>
                <?php }elseif(($outputset->statut == 2)||(empty($outputset->outputs))){ //Outputset annulé ou il n'y a pas des output, afficher bouton grisé  ?>
                <button type="button" class="btn btn-primary" disabled="disabled">
                    <i class="button-fa fa fa-file-text" aria-hidden="true"></i>Valider
                </button>
                <?php }else{ //Outputs Set valider, afficher bouton de succés ?>
                <button type="button" class="btn btn-success" disabled="disabled">
                    <i class="button-fa fa fa-check-circle-o" aria-hidden="true"></i>Valider
                </button>
                <?php } ?>
            </div>
        </div>
        <div class="panel-body">
            <table class="vertical-table table-viewVertical">
                <tr>
                    <th><?= __('Dossier') ?></th>
                    <td><?= $outputset->has('file') ? $this->Html->link($outputset->file->number, ['controller' => 'Files', 'action' => 'view', $outputset->file->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($outputset->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('CreatedBy') ?></th>
                    <td><?= h($outputset->users__created_by->username) ?></td>
                </tr>

            </table>
            <?php if(!empty($lots)){ ?>
            <div id="verifLots" class="alert alert-warning" style="display:none;">
                <strong>Lots restants : <?=count($lots)?></strong>
                <table class="table-warning table table-hover">
                    <thead>
                      <tr>
                        <th>Numéro Lot</th>
                        <th>Produit</th>
                        <th>Quantité déclarée</th>
                        <th>Quantité restante</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach($lots as $key => $value){ ?>
                      <tr>
                        <td><?=$value['number']?></td>
                        <td><?=$value['product_name']?></td>
                        <td><?=$value['expectedQte']?></td>
                        <td><?=$value['remainedQte']?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php }else{ ?>
            <div id="verifLots" class="alert alert-danger" style="display:none;">
                <strong>Lots restants : <?=count($lots)?></strong>
                Pas de lot à ajouter !
            </div>  
            <?php } ?>
            <div class="related">
                <div class="add_block">
                    <div class="add_blockName" style=""><h4><?= __('Bon de sortie') ?></h4></div>
                    <?php 
                        if($outputset->statut == 0){ //Si le dossier est en stock on peut ajouter les bonds de sortie 
                            if($pasDeLot) $cantAddOutput = "cantAddOutput";
                            else $cantAddOutput = "";
                    ?>
                    <div class="add_blockButton" style="">
                        <a id="<?=$cantAddOutput?>" href="<?=$this->Url->build(['controller' => 'Outputs', 'action' => 'add', $outputset->file_id, $outputset->id])?>">
                            <span class="glyphicon glyphicon-plus-sign"></span>
                        </a>
                    </div>
                    <?php } ?>
                </div>
                <?php if (!empty($outputset->outputs)): if($outputset->statut == 0) $widthTab = "tab_width60"; else $widthTab = "tab_width50"; ?>

                <table class="<?=$widthTab?>" cellpadding="0" cellspacing="0">
                    <tr>

                        <th class="widthTh20"><?= __('Numéro Lot') ?></th>
                        <th><?= __('Produit') ?></th>
                        <th><?= __('Quantité') ?></th>
                        <th class="widthTh25"><?= __('Created') ?></th>
                        <?php if($outputset->statut == 0){ ?>
                        <th class="actions"><?= __('Actions') ?></th>
                        <?php } ?>
                    </tr>
                    <?php foreach ($outputset->outputs as $outputs): $lotId = $outputs->lot_id; ?>
                    <tr>

                        <td><?= h($arrayNumberLot[$lotId]['lot_number']) ?></td>
                        <td><?= h($arrayNumberLot[$lotId]['product_name']) ?></td>
                        <td><?= h($outputs->qte) ?></td>
                        <td><?= h($outputs->created) ?></td>
                        <?php if($outputset->statut == 0){ //si le outputsets est en cours ?>
                        <td class="actions">
                            <!--?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Outputs', 'action' => 'view', $outputs->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?-->
                            <!--?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['controller' => 'Outputs', 'action' => 'edit', $outputs->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?-->
                            <?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['controller' => 'Outputs', 'action' => 'delete', $outputs->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $outputs->id)]) ?>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', ['bon de sortie'])?></div>
                </div>
                <?php endif; ?>
            </div>
            <!--?= ($outputset->statut != 0) ? $this->Html->link(__("<i class='fa fa-print action'></i> Imprimer"), ['action' => 'printOutputset', $outputset->id], ['target' => '_blank', 'class' => 'btn btn-default', 'escape' => false]) : '' ?-->


            <div class="related">
                <div class="add_block">
                    <div class="add_blockName" style=""><h4><?= __('Bon à enlever') ?></h4></div>
                </div>
                <?php if (!empty($outputset->removalvoucher)): ?>

                <table class="tab_width50" cellpadding="0" cellspacing="0">
                    <tr>

                        <th><?= __('Bon à enlever') ?></th>
                        <th><?= __('Date') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <tr>
                        <td><?= $this->Html->link(h($outputset->removalvoucher->number), ['controller' => 'OutputSets', 'action' => 'IntegrateOutput', $outputset->removalvoucher->id]) ?></td>
                        <td><?= h($outputset->removalvoucher->number) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'OutputSets', 'action' => 'IntegrateOutput', $outputset->removalvoucher->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <button class="btn btn-default" name="button" data-toggle="modal" data-target="#myModal">
                                <i class='fa fa-truck action'></i>
                            </button>
                        </td>
                    </tr>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', ['bon à enlever'])?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Transporteurs</h4>
      </div>
      <div id="modal-body" class="modal-body">
        
        <?php if(!empty($outputset->removalvoucher->carriers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Raison sociale') ?></th>
                <th><?= __('Tel') ?></th>
            </tr>
            <?php foreach ($outputset->removalvoucher->carriers as $key => $value) { ?>
            <tr>
                <td><?= $this->Html->link(h($value->name), ['controller' => 'Carriers', 'action' => 'view', $value->id])?></td>
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

<?php //echo $text;
    $this->Html->scriptStart(['block' => true]);
        echo "initilizeViewOutputPage();";
    $this->Html->scriptEnd();
?>