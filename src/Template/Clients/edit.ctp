<?=$this->assign('title', 'Clients');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <!--li></?= $this->Form->postLink(
                __('Supprimer'),
                ['action' => 'delete', $client->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $client->id)]
            )
        ?></li-->
        <li><?= $this->Html->link(__('Liste Clients'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste Dossiers'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau Dossier'), ['controller' => 'Files', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste Lots'), ['controller' => 'Lots', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="clients form large-9 medium-8 columns content">
    <?= $this->Form->create($client) ?>
    <fieldset>
        <div class="nopadding panel panel-success">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Modifier client') ?></legend>
            </div>
            <div class="panel-body">
                <div class="block form-group">
                     <div class="col-md-12 display-flex">
                            <div class="col-md-6 panel panel-default panel-border">
                                <div class="panel-heading">Inforamtions Générales</div>
                                <div class="panel-body">
                                    <?php
                                        echo        $this->Form->input('name', ['class'=>'input-60 input-style form-control']);
                                        echo        $this->Form->input('entrepositaire', ['type' => 'checkbox', 'value' => 1, 'hiddenField' => false]);
                                        //echo        $this->Form->label('entrepositaire', 'Type');
                                        echo        $this->Form->input('matriculeFiscale', ['class' => 'input-60 input-style form-control']);
                                        echo        $this->Form->input('code', ['class' => 'input-60 input-style form-control']);
                                        echo        $this->Form->input('approved', ['label' => 'Activer']);
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-6 panel panel-default panel-border">
                                <div class="panel-heading">Contact</div>
                                <div class="panel-body">
                                    <?php
                                        echo        $this->Form->input('adress', ['class' => 'input-60 input-style form-control']);
                                        echo        $this->Form->input('email1', ['class' => 'input-60 input-style form-control']);
                                        echo        $this->Form->input('tel1', ['class' => 'input-40 input-style form-control']);
                                        echo        $this->Form->input('fax1', ['class' => 'input-40 input-style form-control']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    <div class="panel-group">
                        <div class="panel">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    <a id="autreInfo" data-toggle="collapse" href="#collapse1" class="btn btn-default">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                        Autre Informations
                                    </a>
                                </h2>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse">
                              <div class="panel-body">
                              <?php
                                  echo $this->Form->input('email2', ['class' => 'input-20 input-style form-control']);
                                  echo $this->Form->input('email3', ['class' => 'input-20 input-style form-control']);
                                  echo $this->Form->input('tel2', ['class' => 'input-20 input-style form-control']);
                                  echo $this->Form->input('tel3', ['class' => 'input-20 input-style form-control']);
                                  echo $this->Form->input('fax2', ['class' => 'input-20 input-style form-control']);
                                  echo $this->Form->input('fax3', ['class' => 'input-20 input-style form-control']);
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
<?php
    $this->Html->scriptStart(['block' => true]);
        echo "initializeEditClientPage();";
    $this->Html->scriptEnd();
?>
