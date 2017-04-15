<?= $this->Form->create(null, ['url' => ['controller' => 'OutputSets', 'action' => 'integrateOutput']]) ?>
<h3>Groupement des bons de sortie : </h3>
<table cellpadding='0' cellspacing='0' class="tab_width60">
    <thead>
        <tr>
            <th class="widthTh10"></th>
            <th>File</th>
            <th><?=__('Provider')?></th>
            <!--th>date</th-->
            <th>Nbr Bons de sortie</th>
            <th>Consulter</th>
        </tr>
    </thead>
    <tbody>
    
    <?php foreach($outputsets as $key => $value){
        $fileNum = $value['fileNum'];
        $providerName = $value['providerName'];
        //$date = $value['date']; ?>
        <tr>
            <td> <?= $this->Form->input('', ['type' => 'checkbox', 'class' => 'checkbox_list', 'name' => 'checkOutputSets[]', 'value' => $value['id'], 'hiddenField' => false]) ?> </td>
            <td> <?= $fileNum ?> </td>
            <td> <?= $providerName ?> </td>
            <!--td> </?= $date ?> </td-->
            <td> <?= $value['numberOutputs'] ?> </td>
            <td> <?= $this->Html->link(__("<i class='fa fa-folder-open action'></i>"), ['controller' => 'OutputSets', 'action' => 'view', $value['id']], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank', 'escape' => false]) ?> </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<!--date_rv-->
<?= $this->Form->input('date_year', array('id' => 'date_year', 'type' => 'hidden')); ?>
<?= $this->Form->input('date_month', array('id' => 'date_month', 'type' => 'hidden')); ?>
<?= $this->Form->input('date_day', array('id' => 'date_day', 'type' => 'hidden')); ?>
<!--carriers-->
<?= $this->Form->input('carriers', array('id' => 'carriers', 'type' => 'hidden')); ?>
<!--Client-->
<?= $this->Form->input('idClient2', array('id' => 'idClient2', 'type' => 'hidden')); ?>
<!--Entrepositaire-->            
<?= $this->Form->input('idClient', array('id' => 'idClient', 'type' => 'hidden')); ?>
<?= $this->Form->button('Envoyer', ['type' => 'submit', 'class' => 'btn btn-primary',  'onclick' => 'change_idclient_beforeSend();']); ?>
<?= $this->Form->end() ?>

<button class="btn btn-primary" name="button" id="preview_btn" data-toggle="modal" data-target="#myModal">Aperçu</button>
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Bons de sortie</h4>
      </div>
      <div id="modal-body" class="modal-body">
        <!-- Content generate by Ajax : myscript.js > initilizeChooseClientPage -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--button type="button" class="btn btn-primary">Save changes</button-->
      </div>
    </div>
  </div>
</div>