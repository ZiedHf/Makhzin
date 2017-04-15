<?php 
    if(($minStock['type'] == 'product')&&($minStock['id'] == $product['id'])&&($minStock['stockLibre'] !== 'Null')) 
        $class = 'alert-stock'; 
    else 
        $class = '';
?>
<h3>Produit : <b><u><?=$product['name']?></u></b></h3>
        <table id='catTable'>
            <tr>
                <th>productCode</th>
                <th>ngpCode</th>
                <th>barCode</th>
                <th>Quota</th>
                <th>Tolerance</th>
                <th>Stock</th>
            </tr>
            <tr class="<?=$class?>">
                <td><?=$product['productCode']?></td>
                <td><?=$product['ngpCode']?></td>
                <td><?=$product['barCode']?></td>
                <td><?=($product['quota'] === Null) ? '-' : $product['quota']?></td>
                <td><?=($product['quota'] === Null) ? '-' : $product['tolerance']?></td>
                <td><?=$infoTab['product']['stock']?></td>
            </tr>
        </table>
        <!--Information les categories-->
        <br>
        <h3>Les categories : </h3>
        <?php if(!empty($idcategoryTab)){ ?>
        <table id='catTable'>
            <tr>
                <th>Nom Categorie</th>
                <th>Quota</th>
                <th>Tolerance</th>
                <th>Stock</th>
            </tr>
            <?php 
            foreach($product['categories'] as $key => $value){
                if(($minStock['type'] == 'category')&&($minStock['id'] == $value['id'])) $class = 'alert-stock';
                else $class = '';
                $idcateg = $value['id'];
            ?>
                <tr class='<?=$class?>'><td><?=$value['name']?></td>
                    <td><?=$value['quota']?></td>
                    <td><?=$value['tolerance']?></td>
                    <td><?=$infoTab['categories'][$idcateg]['stock']?></td>
                </tr>
            <?php } ?>
            </table>
        <?php }else{ ?>
            <div class='panel panel-default'>
                    <div class='panel-body'><?=__('Vide', ['e', 'catégorie'])?></div>
            </div>
        <?php } ?>
        <!--//Information sur les dependances-->
        
        <br>
        <h3>Les dépandances :</h3>
        <?php if(!$pasDependece){ ?>
        <table id='depTable'>
        <tr>
            <th>Categorie N°1</th>
            <th>Categorie N°2</th>
            <th>Quota</th>
            <th>Tolerance</th>
            <th>Stock</th>
        </tr>
        <?php 
        foreach ($dependencies as $key => $value){
            if(($minStock['type'] == 'dependency')&&($minStock['id'] == $value['id'])) $class = 'alert-stock';
            else $class = '';
            if($value['id_category1'] != $value['id_category2']){
                $nameCat1 = $this->getNameByIdCategory($value['id_category1']);
                $nameCat2 = $this->getNameByIdCategory($value['id_category2']);
        ?>
                <tr class='".$class."'><td><?=$nameCat1?></td>
                    <td><?=$nameCat2?></td>
                    <td><?=$value['quota']?></td>
                    <td><?=$value['tolerance']?></td>
                    <td><?=$value['stock']?></td></tr>
        <?php
            }
        }
        ?>
        </table>
        <?php
        }else{
        ?>
            <div class='panel panel-default'>
                    <div class='panel-body'><?=__('Vide', ['e', 'dépendance'])?></div>
            </div>
        <?php } ?>
        <div class='hide alert-quotaTolerance alert alert-info fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Tolerance : </strong> <span id='mintolerance'><?=$minStock['tolerance']?></span>
                <strong>Amount Stock : </strong> <span id='amountStock'><?=$minStock['stockLibre']?></span>
        </div>