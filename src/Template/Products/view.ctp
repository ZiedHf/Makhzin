<?=$this->assign('title', 'Produits');?><?php //debug($product); die(); ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Liste Produits'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Modifier Produit'), ['action' => 'edit', $product->id]) ?> </li>
        <!--li></?= $this->Form->postLink(__('Supprimer Produit'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?> </li-->
        <li><?= $this->Html->link(__('Nouveau Produit'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvelle Categorie'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Stocks'), ['controller' => 'Stocks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="products view large-9 medium-8 columns content">
    <div class="nopadding panel panel-info">
        <div class="panel-heading">
            <h3 class="indexH3Inline2"><?= h($product->name) ?></h3>
        </div>
        <div class="panel-body">
            <div class="container">
                <div class="col-md-6">
                    <table class="vertical-table table-view100">
                        <tr>
                            <th><?= __('Name') ?></th>
                            <td><?= h($product->name) ?></td>
                            <th><?= __('ProductCode') ?></th>
                            <td><?= h($product->productCode) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('NgpCode') ?></th>
                            <td><?= h($product->ngpCode) ?></td>
                            <th><?= __('BarCode') ?></th>
                            <td><?= h($product->barCode) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Etat produit') ?></th>
                            <td><?= h($product->productstate->name) ?></td>
                            <th><?= __('Unit') ?></th>
                            <td><?= h($product->unit) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Quota') ?></th>
                            <td><?= ($product->quota === Null) ? '-' : $this->Number->format($product->quota) ?></td>
                            <th><?= __('Tolerance') ?></th>
                            <td><?= $this->Number->format($product->tolerance) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('UnitQte') ?></th>
                            <td><?= ($product->unitQte !== Null) ? $this->Number->format($product->unitQte) : '-' ?></td>
                            <th><?= __('Approved') ?></th>
                            <td><?= $product->approved ? __('Yes') : __('No'); ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Created') ?></th>
                            <td><?= h($product->created->format('d-m-Y')) ?></td>
                            <th><?= __('Zone Préférée') ?></th>
                            <td><?= isset($product->zone->name) ? $product->zone->name : '-' ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Crée par') ?></th>
                            <td><?= (isset($product->users__created_by->username)) ? h($product->users__created_by->username) : '-' ?></td>
                            <th><?= __('Modifié par') ?></th>
                            <td><?= (isset($product->users__modified_by->username)) ? h($product->users__modified_by->username) : '-' ?></td>
                        </tr>
                        <tr>
                            <th><?= __('SubjectToQuota') ?></th>
                            <td><?= $product->subjectToQuota ? __('Yes') : __('No'); ?></td>
                            <th><?= __('Amount') ?></th>
                            <td><?= $product->stock->amount; ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Packaging') ?></th>
                            <td><?= $product->packaging->name; ?></td>
                            <th><?= __('Packaging type') ?></th>
                            <td><?= ($product->packaging->type !== Null) ? $product->packaging->type : '-'; ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Packaging weight') ?></th>
                            <td><?= ($product->packaging->weight !== Null) ? $product->packaging->weight : '-'; ?></td>
                            <th><?= __('Pièce Jointe') ?></th>
                            <td><?= ($product->doc_path !== NULL) ? $this->Html->link(__('<i class="fa fa-file-text" aria-hidden="true"></i>'), ['action' => 'viewDoc', $product->id], ['escape' => false]) : '-'; ?></td>
                        </tr>
                    </table>

                </div>
                <div class="col-md-6">
                    <?php if($product->pic_path !== NULL){ ?>
                    <?= $this->Html->image($this->Url->build(['controller' => 'Products', 'action' => 'viewPic',
                                                                $product->id
                                                            ], true), 
                            ['class' => 'img-thumbnail img-responsive', 
                            'style' => 'max-height:300px; margin-left: auto; margin-right: auto; display: block;']); 
                    ?>
                    <?php }else{ ?>
                    <div class="panel panel-default">
                        <div class="panel-body"><?=__('VideM', ['Image'])?></div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php if(($product->description_product !== NULL) && ($product->description_product !== '')){ ?>
                <div>
                    <h4><?= __('Description') ?></h4>
                    <div class="alert alert-info" role="alert"><?= $this->Text->autoParagraph(h($product->description_product)); ?></div>
                </div>
            <?php } ?>
            <div class="related">
                <h4><?= __('Les Categories') ?></h4>
                <?php if (!empty($product->categories)): ?>
                <table cellpadding="0" cellspacing="0" class="tab_width50">
                    <tr>
                        <th><?= __('Name') ?></th>
                        <th><?=__('Considered') ?></th>
                        <th><?= __('Created') ?></th>
                        <th><?= __('Modified') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($product->categories as $categories): ?>
                    <tr>
                        <td><?= $this->Html->link(h($categories->name), ['controller' => 'Categories', 'action' => 'view', $categories->id], ['escape' => false]) ?></td>
                        <td><?= ($categories['_joinData']['is_considered'] == 1) ? __('Yes') : __('No') ?></td>
                        <td><?= h($categories->created->format('d-m-Y')) ?></td>
                        <td><?= h($categories->modified->format('d-m-Y')) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Categories', 'action' => 'view', $categories->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['controller' => 'Categories', 'action' => 'edit', $categories->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                            <!--?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['controller' => 'Categories', 'action' => 'delete', $categories->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $categories->id)]) ?-->
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body"><?=__('VideF', ['catégorie'])?></div>
                </div>
                <?php endif; ?>
            </div>

            <div class="related">
                <h4><?= __('Les Lots') ?></h4>
                <?php $i = 0; if (!empty($product->lots)): $i++; ?>
                <table cellpadding="0" cellspacing="0" class="tab_width80">
                    <tr>
                        <th class="widthTh5">N°</th>
                        <th><?= __('Number') ?></th>
                        <th><?= __('File Id') ?></th>
                        <th><?= __('Client Id') ?></th>
                        <th><?= __('Deadline') ?></th>
                        <th><?= __('ExpectedQte') ?></th>
                        <th><?= __('Created') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($product->lots as $lots): ?>
                    <tr>
                        <td><?= h($i) ?></td>
                        <td><?= $this->Html->link(h($lots->number), ['controller' => 'Lots', 'action' => 'view', $lots->id], ['escape' => false]) ?></td>
                        <td><?= $this->Html->link(h($file_num[$lots->id]), ['controller' => 'Files', 'action' => 'view', $lots->file_id], ['escape' => false]) ?></td>
                        <td><?= $this->Html->link(h($client_name[$lots->id]), ['controller' => 'Clients', 'action' => 'view', $lots->client_id], ['escape' => false]) ?></td>
                        <td><?= h($lots->deadline->format('d-m-Y')) ?></td>
                        <td><?= h($lots->expectedQte) ?></td>
                        <td><?= h($lots->created->format('d-m-Y')) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'Lots', 'action' => 'view', $lots->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                            <!--?= $this->Html->link(__("<i class='fa fa-pencil-square-o action'></i>"), ['controller' => 'Lots', 'action' => 'edit', $lots->id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?-->
                            <!--?= $this->Form->postLink(__("<i class='fa fa-times action'></i>"), ['controller' => 'Lots', 'action' => 'delete', $lots->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $lots->id)]) ?-->
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
        </div>
    </div>
</div>
