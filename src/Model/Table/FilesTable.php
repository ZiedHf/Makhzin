<?php
namespace App\Model\Table;

use App\Model\Entity\File;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Files Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clients
 * @property \Cake\ORM\Association\BelongsTo $Inputs
 * @property \Cake\ORM\Association\HasMany $Documents
 * @property \Cake\ORM\Association\HasMany $Inputs
 * @property \Cake\ORM\Association\HasMany $Lots
 * @property \Cake\ORM\Association\HasMany $Outputs
 */
class FilesTable extends Table
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

        $this->table('files');
        $this->displayField('number');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Providers', [
            'foreignKey' => 'provider_id',
        ]);
        /*$this->belongsTo('Inputs', [
            'foreignKey' => 'input_id'
        ]);*/
        $this->hasMany('Documents', [
            'foreignKey' => 'file_id'
        ]);
        $this->hasOne('Inputs', [
            'foreignKey' => 'file_id'
        ]);
        $this->hasMany('Lots', [
            'foreignKey' => 'file_id'
        ]);
        $this->hasMany('Outputs', [
            'foreignKey' => 'file_id'
        ]);
        $this->hasMany('OutputSets', [
            'className' => 'output_sets',
            'foreignKey' => 'file_id'
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
            ->date('startDate')
            ->allowEmpty('startDate');

        $validator
            ->boolean('canceled')
            ->allowEmpty('canceled');

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
        $rules->add($rules->isUnique(['number']));
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['input_id'], 'Inputs'));
        return $rules;
    }
}
