<?php if((isset($outPutSetsData)) && ($outPutSetsData !== null)){ ?>
<div class="related">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('File') ?></th>
            <th><?= __('Numéro Lot') ?></th>
            <th><?= __('Produit') ?></th>
            <th><?= __('Quantité') ?></th>
            <th><?= __('Date') ?></th>
        </tr>
        <?php foreach($outPutSetsData as $outputSet){
                foreach($outputSet['outputset']['outputs'] as $output){ 
                    $lotId = $output->lot_id; 
        ?>
        <tr>
            <td><?= h($outputSet['outputset']['file']->number) ?></td>
            <td><?= h($outputSet['arrayNumberLot'][$lotId]['lot_number']) ?></td>
            <td><?= h($outputSet['arrayNumberLot'][$lotId]['product_name']) ?></td>
            <td><?= h($output->qte) ?></td>
            <td><?= h($output->date) ?></td>
        </tr>
        <?php }} ?>
    </table>
</div>
<?php }else{ ?>
<div class="panel panel-default">
    <div class="panel-body"><?=__('VideM', ['bon de sortie'])?></div>
</div>
<?php } ?>
