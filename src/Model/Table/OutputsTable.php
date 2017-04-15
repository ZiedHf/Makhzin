<?php
namespace App\Model\Table;

use App\Model\Entity\Output;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Outputs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Lots
 * @property \Cake\ORM\Association\BelongsTo $Files
 * @property \Cake\ORM\Association\BelongsTo $Outputsets
 */
class OutputsTable extends Table
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

        $this->table('outputs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Lots', [
            'foreignKey' => 'lot_id'
        ]);
        $this->belongsTo('Files', [
            'foreignKey' => 'file_id'
        ]);
        $this->belongsTo('OutputSets', [
            'foreignKey' => 'outputSet_id'
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

        /*$validator
            ->date('date')
            ->allowEmpty('date');*/

        $validator
            ->numeric('qte')
            ->allowEmpty('qte');

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
        $rules->add($rules->existsIn(['lot_id'], 'Lots'));
        $rules->add($rules->existsIn(['file_id'], 'Files'));
        $rules->add($rules->existsIn(['outputSet_id'], 'OutputSets'));
        return $rules;
    }
}
