<?=$this->assign('title', 'Fournisseurs');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <!--li></?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $provider->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $provider->id)]
            )
        ?></li-->
        <li><?= $this->Html->link(__('Liste fournisseurs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste Dossiers'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Dossier'), ['controller' => 'Files', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="providers form large-9 medium-8 columns content">
    <?= $this->Form->create($provider) ?>
    <fieldset>
        <div class="block form-group">
            <div class="nopadding panel panel-success">
                <div class="panel-heading">
                    <legend class="labelClass"><?= __('Modifier Fournisseur') ?></legend>
                </div>
                <div class="panel-body">
                    <div class="block form-group">
                        <div class="col-md-12 display-flex">
                            <div class="col-md-6 panel panel-default panel-border">
                                <div class="panel-heading">Inforamtions Générales</div>
                                <div class="panel-body">
                                    <?php
                                    echo $this->Form->input('name' , ['label'=>'Nom Fournisseur', 'class'=>'input-60 input-style form-control']);
                                    echo $this->Form->input('adress', ['label'=>'Adresse', 'class'=>'input-60 input-style form-control']);
                                    echo $this->Form->input('website', ['label'=>'Site Web', 'class'=>'input-60 input-style form-control']);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6 panel panel-default panel-border">
                                <div class="panel-heading">Contact</div>
                                <div class="panel-body">
                                    <?php
                                    echo $this->Form->input('email', ['class'=>'input-60 input-style form-control']);
                                    echo $this->Form->input('tel', ['label'=>'Téléphone', 'class'=>'input-60 input-style form-control']);
                                    echo $this->Form->input('fax', ['class'=>'input-60 input-style form-control']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
