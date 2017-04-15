<?php //debug($category);die(); ?>
<?=$this->assign('title', 'Catégories');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Modifier Categorie'), ['action' => 'edit', $category->id]) ?> </li>
        <!--li></?= $this->Form->postLink(__('Supprimer Categorie'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?> </li-->
        <li><?= $this->Html->link(__('Liste Categories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Categorie'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Liste Produits'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Produit'), ['controller' => 'Products', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="categories view large-9 medium-8 columns content">
    <div class="nopadding panel panel-info">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= h($category->name) ?></h3>
        </div>
        <div class="panel-body">
        <div class="container">
            <div class="col-md-6">
                <table class="vertical-table table-viewVertical70">
                    <tr>
                        <th><?= __('Nom Categorie') ?></th>
                        <td><?= h($category->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Quota') ?></th>
                        <td><?= $quota ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Tolérance') ?></th>
                        <td><?= $tolerance ?></td>
                    </tr>
                    <tr>
                        <th><?= __('En Stock') ?></th>
                        <td><?= $amount ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Crée par') ?></th>
                        <td><?= (isset($category->users__created_by->username)) ? h($category->users__created_by->username) : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($category->created->format('d-m-Y')) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modifié par') ?></th>
                        <td><?= (isset($category->users__modified_by->username)) ? h($category->users__modified_by->username) : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($category->modified->format('d-m-Y')) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Pièce Jointe 1') ?></th>
                        <td><?= ($category->doc_path !== NULL) ? $this->Html->link(__('<i class="fa fa-file-text" aria-hidden="true"></i>'), ['action' => 'viewDoc', $category->id, 1], ['escape' => false]) : '-'; ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Pièce Jointe 2') ?></th>
                        <td><?= ($category->doc_path2 !== NULL) ? $this->Html->link(__('<i class="fa fa-file-text" aria-hidden="true"></i>'), ['action' => 'viewDoc', $category->id, 2], ['escape' => false]) : '-'; ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Pièce Jointe 3') ?></th>
                        <td><?= ($category->doc_path3 !== NULL) ? $this->Html->link(__('<i class="fa fa-file-text" aria-hidden="true"></i>'), ['action' => 'viewDoc', $category->id, 3], ['escape' => false]) : '-'; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <?php if($category->pictogramme_path !== NULL){ ?>
                <!--?= $this->Html->image("http://localhost/DSD/categories/viewPic/$category->id", 
                        ['class' => 'img-thumbnail img-responsive', 
                        'style' => 'max-height:300px; margin-left: auto; margin-right: auto; display: block;']); 
                ?-->
                <?= $this->Html->image($this->Url->build(['controller' => 'Categories',
                                                            'action' => 'viewPic',
                                                            $category->id
                                                        ], true), 
                        ['class' => 'img-thumbnail img-responsive', 
                        'style' => 'max-height:300px; margin-left: auto; margin-right: auto; display: block;']); 
                ?>
                <?php }else{ ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideM', ['Pictogramme'])?></div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php if(($category->description_categ !== NULL) && ($category->description_categ !== '')){ ?>
            <div>
                <h4><?= __('Description') ?></h4>
                <div class="alert alert-info" role="alert"><?= $this->Text->autoParagraph(h($category->description_categ)); ?></div>
            </div>
        <?php } ?>
        <div class="related">
            <div class="add_block">
            <div class="add_blockName" style=""><h4><?= __('Les Produits') ?></h4></div>
            <div class="add_blockButton" style="">
                <?= $this->Html->link(__('<span class="glyphicon glyphicon-plus-sign"></span>'), ['controller' => 'Products', 'action' => 'add', $category->id], ['escape' => false]) ?>
            </div>
            </div>

            <?php if (!empty($category->products)): ?>
            <table cellpadding="0" cellspacing="0" class="tab_width90">
                <tr>
                    <th class="widthTh5">N°</th>
                    <th class="widthTh20"><?= __('Nom Produit') ?></th>
                    <th><?= __('Code') ?></th>
                    <th><?= __('Unité') ?></th>
                    <th><?= __('Quota') ?></th>
                    <th><?= __('Tolerance') ?></th>
                    <th><?= __('Emballage') ?></th>
                    <th><?=__('Considered')?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php $i = 0; foreach ($category->products as $products): $i++; ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $this->Html->link(h($products->name), ['controller' => 'Products', 'action' => 'view', $products->id], ['escape' => false]) ?></td>
                    <td><?= h($products->productCode) ?></td>
                    <td><?= h($products->unit) ?></td>
                    <td><?= h($products->quota) ?></td>
                    <td><?= h($products->tolerance) ?></td>
                    <td><?= h($products->emballage) ?></td>
                    <td><?= ($products->_joinData['is_considered'] == 1) ? __('Yes') : __('No') ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Products', 'action' => 'view', $products->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                        <?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['controller' => 'Products', 'action' => 'edit', $products->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                        <!--?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['controller' => 'Products', 'action' => 'delete', $products->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $products->id)]) ?-->
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
            <div class="panel panel-default">
                <div class="panel-body"><?=__('VideM', ['produit'])?></div>
            </div>
            <?php endif; ?>
        </div>
        <div class="related">

            <div class="add_block">
            <div class="add_blockName" style=""><h4><?= __('Les Dependances') ?></h4></div>
            <div class="add_blockButton" style="">
                <?= $this->Html->link(__('<span class="glyphicon glyphicon-plus-sign"></span>'), ['controller' => 'Dependencies', 'action' => 'add', $category->id], ['escape' => false]) ?>
            </div>
            </div>
            <?php if (!empty($dependencies)): ?>
            <table class="tab_width60" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?= __('Categorie N°1') ?></th>
                    <th><?= __('Categorie N°2') ?></th>
                    <th><?= __('Quota') ?></th>
                    <th><?= __('Tolérance') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php 
                    foreach ($dependencies as $dependency):
                        if ($category->name == $categories[$dependency->id_category2]){
                            $nameCat2 = $categories[$dependency->id_category1];
                            $idcat2 = $dependency->id_category1;
                            $idcat1 = $dependency->id_category2;
                        }else{
                            $nameCat2 = $categories[$dependency->id_category2];
                            $idcat2 = $dependency->id_category2;
                            $idcat1 = $dependency->id_category1;
                        }
                    ?>
                <tr>
                    <td><?= h($category->name) ?></td>
                    <td><?= $this->Html->link(h($nameCat2), ['controller' => 'Categories', 'action' => 'view', $idcat2], ['escape' => false]) ?></td>
                    <td><?= h($dependency->quota) ?></td>
                    <td><?= h($dependency->tolerance) ?></td>
                    <td class="actions">
                        <!--?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Dependencies', 'action' => 'view', $dependency->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>-->
                        <?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['controller' => 'Dependencies', 'action' => 'edit', $idThisCat, $dependency->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                        <?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['controller' => 'Dependencies', 'action' => 'delete', $idThisCat, $dependency->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $dependency->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
            <div class="panel panel-default">
                <div class="panel-body"><?=__('VideF', ['dépendance'])?></div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    </div>
</div>
