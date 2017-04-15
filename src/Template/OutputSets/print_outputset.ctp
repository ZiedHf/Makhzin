<?=$this->assign('title', 'Groupement des bons de sortie');?>
<div id="bonAlever">    
    <div class="well-print well well-md text-center">
        <span class="pull-right">Date groupement des bons de sortie : <?=$outputset->date->format('d-m-Y')?></span>
        <h3 class="">Palliser international</h3>
        <h5>Groupement des bons de sortie - <?=$outputset->file->number?></h5>
    </div>
    <div class="col-md-12 display-flex">
        
        <div class="panel panel-default col-xs-7 col-sm-7">
            <div class="panel-heading">Dossier</div>
            <div class="panel-body">
                <table class="table table-infoDossier">
                    <tr>
                        <td>Numéro Dossier</td>
                        <td>Date</td>
                        <td>Statut</td>
                    </tr>
                    <tr>
                        <td><?=$outputset->file->number?></td>
                        <td><?=$outputset->file->startDate->format('d-m-Y')?></td>
                        <td><?=$statuts[$outputset->file->statut]?></td>
                    </tr>
                    <tr class="cel-padding-top">
                        <td>Client</td>
                        <td>Fournisseur</td>
                        <td>Bon de sortie</td>
                    </tr>
                    <tr>
                        <td><?=$nameClient?></td>
                        <td><?=$nameProvider?></td>
                        <td><?=$nombreOutputs?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="panel panel-default col-xs-5 col-sm-5">
            <div class="panel-heading">Palliser International</div>
            <div class="panel-body">
                <div class="well well-sm">61 Rue Mohamed Manachou <br><br> 1089 Montfleury - Tunis<br><br>Tél : 71.483.189</div>
            </div>
        </div>
    </div>
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
        <?php if (!empty($outputset->outputs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                
                <th><?= __('Numéro Lot') ?></th>
                <th><?= __('Produit') ?></th>
                <th>Code</th>
                <th>Ngp</th>
                <th><?= __('Quantité') ?></th>
                <th><?= __('Date') ?></th>
                <?php if($outputset->statut == 0){ ?>
                <th class="actions"><?= __('Actions') ?></th>
                <?php } ?>
            </tr>
            <?php foreach ($outputset->outputs as $outputs): $lotId = $outputs->lot_id; ?>
            <tr>
                
                <td><?= h($arrayNumberLot[$lotId]['lot_number']) ?></td>
                <td><?= h($arrayNumberLot[$lotId]['product_name']) ?></td>
                <td><?=h($arrayNumberLot[$lotId]['product_code'])?></td>
                <td><?=h($arrayNumberLot[$lotId]['product_ngp'])?></td>
                <td><?= h($outputs->qte) ?></td>
                <td><?= h($outputs->date) ?></td>
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
            <div class="panel-body"><?=__('VidePrint', ['bon de sortie'])?></div>
        </div>
        <?php endif; ?>
    </div>
    <div class="content">
        <div class="col-xs-4 col-sm-4">
            Tél : 71.483.189<br>
            Fax : 71.483.160<br>
        </div>
        <div class="col-xs-4 col-sm-4">Commerce International</div>
        <div class="col-xs-4 col-sm-4">Email : palliserinter@gmail.com</div>
    </div>
</div>
<?php //echo $text;
    $this->Html->scriptStart(['block' => true]);
        echo "initilizeprintOutputsetPage();";
    $this->Html->scriptEnd();
?>