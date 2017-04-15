<!--?=$this->Html->link(__("<button type='button' class='btn btn-default' data-toggle='tooltip' data-placement='top' title='Cliquez pour modifier'>". h($actualQte)." ".$icon ."</button>"),
                                ['action' => '#'], 
                                ['data-toggle' => 'modal', 'data-target' => '#IdLot_'.$idLot, 'escape' => false])?-->

<?php print json_encode($data); ?>