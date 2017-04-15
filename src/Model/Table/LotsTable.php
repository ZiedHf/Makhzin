<?php
namespace App\Model\Table;

use App\Model\Entity\Lot;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Lots Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Products
 * @property \Cake\ORM\Association\BelongsTo $Clients
 * @property \Cake\ORM\Association\BelongsTo $Zones
 * @property \Cake\ORM\Association\BelongsTo $Inputs
 * @property \Cake\ORM\Association\BelongsTo $Files
 * @property \Cake\ORM\Association\HasMany $Outputs
 */
class LotsTable extends Table
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

        $this->table('lots');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id'
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
        ]);
        $this->belongsTo('Zones', [
            'foreignKey' => 'zone_id'
        ]);
        $this->belongsTo('Inputs', [
            'foreignKey' => 'input_id'
        ]);
        $this->belongsTo('Files', [
            'foreignKey' => 'file_id'
        ]);
        $this->hasMany('Outputs', [
            'foreignKey' => 'lot_id'
        ]);
        $this->hasMany('Movements', [
            'foreignKey' => 'lot_id'
        ]);
        $this->belongsTo('Users_CreatedBy', [
            'className' => 'Users',
            'foreignKey' => 'created_by'
        ]);
        $this->belongsTo('Users_ModifiedBy', [
            'className' => 'Users',
            'foreignKey' => 'modified_by'
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
            ->requirePresence('number', 'create')
            ->notEmpty('number')
            ->add('number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->date('deadline')
            ->allowEmpty('deadline');
        
        $validator
            ->date('deadlineConsumption')
            ->allowEmpty('deadlineConsumption');

        $validator
            ->numeric('expectedQte')
            ->allowEmpty('expectedQte');

        $validator
            ->numeric('actualQte')
            ->allowEmpty('actualQte');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['zone_id'], 'Zones'));
        $rules->add($rules->existsIn(['input_id'], 'Inputs'));
        $rules->add($rules->existsIn(['file_id'], 'Files'));
        return $rules;
    }
}
