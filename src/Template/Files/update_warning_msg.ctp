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
                        <td><?=$value['actualQte']?></td>
                        <td>
                            <?php 
                                if($value['stockLibre'] < 0)
                                    echo 'Dépassé par : '. abs($value['stockLibre']); 
                                elseif($value['stockLibre'] == 'Null') // Produit n'a pas de seuil, illimité.
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