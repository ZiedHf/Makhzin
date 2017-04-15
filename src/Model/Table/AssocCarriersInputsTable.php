<?php
namespace App\Model\Table;

use App\Model\Entity\AssocCarriersInput;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AssocCarriersInputs Model
 *
 */
class AssocCarriersInputsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('assoc_carriers_inputs');
        $this->displayField('id');
        $this->primaryKey('id');
        
        $this->belongsTo('Carriers', [
            'foreignKey' => 'carrier_id'
        ]);
        $this->belongsTo('Inputs', [
            'foreignKey' => 'input_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('carrier_id')
            ->requirePresence('carrier_id', 'create')
            ->notEmpty('carrier_id');

        $validator
            ->integer('input_id')
            ->requirePresence('input_id', 'create')
            ->notEmpty('input_id');

        return $validator;
    }
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['carrier_id'], 'Carriers'));
        $rules->add($rules->existsIn(['input_id'], 'Inputs'));
        return $rules;
    }
}
