<?php
namespace App\Model\Table;

use App\Model\Entity\Movement;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Movements Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Stocks
 * @property \Cake\ORM\Association\BelongsTo $Lots
 */
class MovementsTable extends Table
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

        $this->table('movements');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Stocks', [
            'foreignKey' => 'stock_id'
        ]);
        $this->belongsTo('Lots', [
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
            ->integer('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->dateTime('date')
            ->allowEmpty('date');

        $validator
            ->numeric('qte')
            ->allowEmpty('qte');

        $validator
            ->numeric('before')
            ->allowEmpty('before');

        $validator
            ->numeric('after')
            ->allowEmpty('after');

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
        $rules->add($rules->existsIn(['stock_id'], 'Stocks'));
        $rules->add($rules->existsIn(['lot_id'], 'Lots'));
        return $rules;
    }
}
