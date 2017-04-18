<?=$this->assign('title', 'Bons d\'entrée');?>
<div id="bonEntree">
    <div class="well-print well well-md text-center">
        <h3 class=""><?=COMPANY_NAME?></h3>
        <h5>Bon d'entrée - <?=$input->file->number?></h5>
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
                        <td><?=$input->file->number?></td>
                        <td><?=$input->file->startDate->format('d-m-Y')?></td>
                        <td><?=$statuts[$input->file->statut]?></td>
                    </tr>
                    <tr class="cel-padding-top">
                        <td>Client</td>
                        <td>Fournisseur</td>
                        <td>Nombre lots</td>
                    </tr>
                    <tr>
                        <td><?=$file['client']['name']?></td>
                        <td><?=$file['provider']['name']?></td>
                        <td><?=$nombreLots?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="panel panel-default col-xs-5 col-sm-5">
            <div class="panel-heading"><?=COMPANY_NAME?></div>
            <div class="panel-body">
                <div class="well well-sm"><?=COMPANY_STREET1?> <br><br> <?=COMPANY_STREET2?><br><br>Tél : <?=COMPANY_TEL?></div>
            </div>
        </div>
    </div>
    
    <div class="related">
        <h4><?= __('Lots') ?></h4>
        <?php if (!empty($input->lots)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th class="widthTh5"><?= __('N°') ?></th>
                <th><?= __('Numéro') ?></th>
                <th><?= __('Produit') ?></th>
                <th><?= __('Quantité') ?></th>
                <th><?= __('Code') ?></th>
                <th><?= __('NgpCode') ?></th>
                <th><?= __('Délai Livraison') ?></th>
            </tr>
            <?php $i = 0; foreach ($input->lots as $lots): $i++; ?>
            <tr>
                <td><?= h($i) ?></td>
                <td><?= h($lots->number) ?></td>
                <td><?= h($nameProductArray[$lots->id]) ?></td>
                <td><?= h($lots->actualQte) ?></td>
                <td><?= h($codeProductArray[$lots->id]) ?></td>
                <td><?= h($ngpcodeProductArray[$lots->id]) ?></td>
                <td><?= h($lots->deadline->format('d-m-Y')) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <div class="panel panel-default">
            <div class="panel-body"><?=__('VidePrint', ['lot'])?></div>
        </div>
        <?php endif; ?>
    </div>
    
    <!--div class="related">
        <h4></?= __('Documents') ?></h4>
        </?php if (!empty($file['documents'])): ?>
        <table cellpadding="0" cellspacing="0" class="tab_width80">
            <tr>
                <th class="widthTh10"></?= __('N°') ?></th>
                <th class="widthTh40"></?= __('Nom Document') ?></th>
                <th class="widthTh35"></?= __('Type') ?></th>
                <th></?= __('Version') ?></th>
            </tr>
            </?php $i = 0; foreach ($file['documents'] as $documents): $i++; ?>
            <tr>
                <td></?= h($i) ?></td>
                <td></?= h($documents['name']) ?></td>
                <td></?= h($types[$documents['type']]) ?></td>
                <td></?= $documents['version'] === 0 ? 'Copie' : 'Originale' ?></td>
            </tr>
            </?php endforeach; ?>
        </table>
        </?php else: ?>
        <div class="panel panel-default">
            <div class="panel-body"></?=__('VidePrint', ['document'])?></div>
        </div>
        </?php endif; ?>
    </div-->
    
    <hr>
    <div class="content">
        <div class="col-xs-4 col-sm-4">
            Tél : <?=COMPANY_TEL?><br>
            Fax : <?=COMPANY_FAX?><br>
        </div>
        <div class="col-xs-4 col-sm-4"><?=COMPANY_SLOGAN?></div>
        <div class="col-xs-4 col-sm-4">Email : <?=COMPANY_EMAIL?></div>
    </div>
</div>
<?php //echo $text;
    $this->Html->scriptStart(['block' => true]);
        echo "initilizeprintInputPage();";
    $this->Html->scriptEnd();
?>