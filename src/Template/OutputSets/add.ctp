<?=$this->assign('title', 'Bons à lever');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'display']) ?> </li>
        <li><?= $this->Html->link(__('Retourner au dossier'), ['controller' => 'Files', 'action' => 'view', $file['id']]) ?> </li>
    </ul>
</nav>
<div class="outputsets form large-9 medium-8 columns content">
    <?= $this->Form->create($outputset) ?>
    <fieldset>
        <div class="block form-group">
            <legend><?= __('Ajouter un groupement des bons de sortie') ?></legend>
            <?php
                //echo $this->Form->label('number', 'Numéro du lot', ['class' => 'label-style']);
                //echo $this->Form->input('number', ['label' => false, 'class'=>'input-style form-control input-50', 'value' => $number, 'disabled' => true]);

                echo $this->Form->input('file_number', ['label' => 'Numéro Dossier', 'class'=>'input-style form-control input-15', 'value' => $file['number'], 'disabled' => true]);
                echo $this->Form->input('file_id', ['type' => 'hidden', 'value' => $file['id']]);
                //echo $this->Form->input('date', ['empty' => true]);
                /*echo $this->Form->label('date', 'Date', ['class' => 'label-style']);
                echo $this->Form->input('date', ['year' => ['id' => 'deadlineYear', 
                                                            'class' => 'form-control',
                                                        ],
                                                        'month' => [
                                                            'id' => 'deadlineMonth', 
                                                            'class' => 'form-control',
                                                        ],
                                                        'day' => [
                                                            'id' => 'deadlineDay', 
                                                            'class' => 'form-control',
                                                        ],
                                                        'label' => false
                                                    ]);*/
            ?>
        </div>
    </fieldset>
    <?= $this->Form->button('Valider', ['id' => 'btnEnvoyer', 'type' => 'submit', 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
