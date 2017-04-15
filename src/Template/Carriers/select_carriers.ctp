<?=$this->assign('title', 'Catégories');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
    </ul>
</nav>
<div class="categories form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <div class="nopadding panel panel-warning">
            <div class="panel-heading">
                <legend class="labelClass"><?= __('Choisir les transporteurs') ?></legend>
            </div>
            <div class="panel-body">
                <?php if(($error != 0) || (!isset($error))){ ?>
                    <br>
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?=$errorMsg?>
                    </div>
                <?php } ?>

                    <?= $this->Form->input('typeTrait', ['type' => 'hidden', 'value' => $type]); ?>
                <div class="block form-group">
                    <div class="block form-group">
                        <div class="col-md-12 display-flex">
                            <div class="col-md-12 panel panel-default panel-border">
                                <div class="panel-heading">Transporteurs</div>
                                <div class="panel-body">
                                        <div class="col-xs-5">
                                            <select name="from[]" id="multiselect_carriers" class="form-control" size="8" multiple="multiple">
                                                <?php foreach ($carriers as $key => $value) { ?>
                                                    <option value="<?=$key;?>"><?=$value;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-xs-2">
                                            <button type="button" id="multiselect_carriers_rightAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                            <button type="button" id="multiselect_carriers_rightSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                            <button type="button" id="multiselect_carriers_leftSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                            <button type="button" id="multiselect_carriers_leftAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                        </div>

                                        <div class="col-xs-5">
                                            <select name="to[]" id="multiselect_carriers_to" class="form-control" size="8" multiple="multiple"></select>
                                        </div>
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
