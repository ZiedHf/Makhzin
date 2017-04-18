<?=$this->assign('title', 'Bon à enlever');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Retourner à la liste'), ['controller' => 'Removalvouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__("Imprimer"), ['controller' => 'Removalvouchers', 'action' => 'printRemovalVoucher', $id_rv], ['target' => '_blank']) ?></li>
    </ul>
</nav>
<div class="removalvouchers view large-9 medium-8 columns content">
    <div id="bonAlever">    
        <div class="well-print well well-md text-center">
            <h3 class=""><?=COMPANY_NAME?></h3>
            <h5>Bon à enlever</h5>
        </div>

        <div class="col-md-12 display-flex">

            <div class="panel panel-default col-xs-6 col-sm-6">
                <div class="panel-heading">Informations</div>
                <div class="panel-body">
                    <table class="table table-infoDossier">

                        <tr class="cel-padding-top">
                            <td>Entrepositaire</td>
                            <td>Client</td>
                            <td>Fournisseur</td>
                        </tr>
                        <tr>
                            <td><?=$nameEntrepositaire?></td>
                            <td><?=$nameClient?></td>
                            <td><?=$nameProvider?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel panel-default col-xs-6 col-sm-6">
                <div class="panel-heading"><?=COMPANY_NAME?></div>
                <div class="panel-body">
                    <div class="well well-sm"><?=COMPANY_STREET1?> <br><br> <?=COMPANY_STREET2?><br><br>Tél : <?=COMPANY_TEL?></div>
                </div>
            </div>
        </div>

        <div class="related">
            <div class="add_block">
                <div class="add_blockName" style=""><h4><?= __('Groupement des bons de sortie') ?></h4></div>
                <?php 
                    //if($outputset->statut == 0){ //Si le dossier est en stock on peut ajouter les bonds de sortie 
                    //    if($pasDeLot) $cantAddOutput = "cantAddOutput";
                    //    else $cantAddOutput = "";
                ?>
                <div class="add_blockButton" style="">
                    <!--a href="</?=$this->Url->build(['controller' => 'Outputs', 'action' => 'add', $outputset->file_id, $outputset->id])?>">
                        <span class="glyphicon glyphicon-plus-sign"></span>
                    </a-->
                </div>
                <?php //} ?>
            </div>
            <?php if (!empty($outPutSetsData)): ?>
            <table cellpadding="0" cellspacing="0" class="tab_width50">
                <tr>
                    <th class="widthTh5"><?= __('N°') ?></th>
                    <!--th></?= __('Date OutputSets') ?></th-->
                    <th><?= __('Numéro Dossier') ?></th>
                    <th><?= __('Date Dossier') ?></th>
                    <th><?= __('Statut du dossier') ?></th>
                    <th><?= __('Bon de sortie') ?></th>
                </tr>
                <?php $i = 0; foreach ($outPutSetsData as $data): $i++; ?>
                <tr>   
                    <td> <?=$i?> </td>
                    <!--td> </?=$data['outputset']->date?> </td-->
                    <td> <?=$data['outputset']->file->number?> </td>
                    <td> <?=$data['outputset']->file->startDate?> </td>
                    <td> <?=$statuts[$data['outputset']->file->statut]?> </td>
                    <td> <?=$data['nombreOutputs']?> </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
            <div class="panel panel-default">
                <div class="panel-body"><?=__('VidePrint', ['bon de sortie'])?></div>
            </div>
            <?php endif; ?>
        </div>

        <div class="related">
            <div class="add_block">
                <div class="add_blockName" style=""><h4><?= __('Inputs') ?></h4></div>
                <?php 
                    //if($outputset->statut == 0){ //Si le dossier est en stock on peut ajouter les bonds de sortie 
                    //    if($pasDeLot) $cantAddOutput = "cantAddOutput";
                    //    else $cantAddOutput = "";
                ?>
                <div class="add_blockButton" style="">
                    <!--a href="</?=$this->Url->build(['controller' => 'Outputs', 'action' => 'add', $outputset->file_id, $outputset->id])?>">
                        <span class="glyphicon glyphicon-plus-sign"></span>
                    </a-->
                </div>
                <?php //} ?>
            </div>
            <?php if (!empty($outPutSetsData)): ?>
            <table cellpadding="0" cellspacing="0"  class="tab_width60">
                <tr>
                    <th class="widthTh5"><?= __('N°') ?></th>
                    <th><?= __('Numéro lot') ?></th>
                    <th><?= __('Numéro Dossier') ?></th>
                    <th><?= __('Nom Produit') ?></th>
                    <th><?= __('Code Produit') ?></th>
                    <th><?= __('NGP Produit') ?></th>
                    <th><?= __('Qte') ?></th>
                </tr>
                <?php 
                    $i = 0; 
                    foreach ($outPutSetsData as $data): 
                        foreach ($data['outputset']->outputs as $dataOutputs):
                            $i++; 
                            $lot_id = $dataOutputs['lot_id'];
                ?>
                        <tr>   
                            <td> <?=$i?> </td>
                            <td> <?=$data['arrayNumberLot'][$lot_id]['lot_number']?> </td>
                            <td> <?=$data['outputset']->file->number?> </td>
                            <td> <?=$data['arrayNumberLot'][$lot_id]['product_name']?> </td>
                            <td> <?=$data['arrayNumberLot'][$lot_id]['product_code']?> </td>
                            <td> <?=$data['arrayNumberLot'][$lot_id]['product_ngp']?> </td>
                            <td> <?=$dataOutputs['qte']?> </td>
                        </tr>
                <?php 
                        endforeach;
                    endforeach; 
                ?>
            </table>
            <?php else: ?>
            <div class="panel panel-default">
                <div class="panel-body"><?=__('VidePrint', ['bon de sortie'])?></div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>