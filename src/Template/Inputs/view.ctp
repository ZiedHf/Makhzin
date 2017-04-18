<?=$this->assign('title', 'Bons d\'entrée');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Retourner au dossier'), ['controller' => 'Files', 'action' => 'view', $input->file->id]) ?> </li>
        <li><?= $this->Html->link(__('Imprimer'), ['action' => 'printInput', $input->id], ['target' => '_blank']) ?></li>
    </ul>
</nav>
<div class="inputs view large-9 medium-8 columns content">
<div id="bonEntreee">
    <div class="well well-md text-center">
        <h2 class=""><?=COMPANY_NAME?></h2>
        <br><h3>Bon d'entrée</h3>
    </div>
    <div class="col-md-12 display-flex">
        <div class="panel panel-default col-md-6">
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
                        <td>Nombre des lots</td>
                    </tr>
                    <tr>
                        <td><?=$file['client']['name']?></td>
                        <td><?=$file['provider']['name']?></td>
                        <td><?=$nombreLots?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="panel panel-default col-md-6">
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
                <th><?= __('Zone') ?></th>
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
                <td><?= h($lots->zone_id) ?></td>
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
        <h4><?= __('Documents') ?></h4>
        <?php if (!empty($file['documents'])): ?>
        <table cellpadding="0" cellspacing="0" class="tab_width60">
            <tr>
                <th class="widthTh5"><?= __('N°') ?></th>
                <th><?= __('Nom Document') ?></th>
                <th class="widthTh40"><?= __('Type') ?></th>
                <th><?= __('Version') ?></th>
            </tr>
            <?php $i = 0; foreach ($file['documents'] as $documents): $i++; ?>
            <tr>
                <td><?= h($i) ?></td>
                <td><?= h($documents['name']) ?></td>
                <td><?= h($types[$documents['type']]) ?></td>
                <td><?= $documents['version'] === 0 ? 'Copie' : 'Originale' ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <div class="panel panel-default">
            <div class="panel-body"><?=__('VideM', ['document'])?></div>
        </div>
        <?php endif; ?>
    </div>
    
    <hr>
    
    
</div>
    <!--a href="" class="btn btn-default" id="printBonEntree" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Imprimer</a-->
    <?= $this->Html->link(__("<i class='fa fa-print action'></i> Imprimer"), ['action' => 'printInput', $input->id], ['target' => '_blank', 'class' => 'btn btn-default', 'escape' => false]) ?>
</div>
<?php /*
    $this->Html->scriptStart(['block' => true]);
        echo "initilizeViewInputPage();";
    $this->Html->scriptEnd();
 * 
 */
?>