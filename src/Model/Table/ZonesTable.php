<?php
namespace App\Model\Table;

use App\Model\Entity\Zone;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Zones Model
 *
 * @property \Cake\ORM\Association\HasMany $Lots
 */
class ZonesTable extends Table
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

        $this->table('zones');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');

        $this->hasMany('Lots', [
            'foreignKey' => 'zone_id'
        ]);
        $this->hasMany('Products', [
            'foreignKey' => 'zone_id'
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
            ->allowEmpty('name');

        $validator
            ->boolean('subjectToQuota')
            ->allowEmpty('subjectToQuota');

        $validator
            ->numeric('quota')
            ->allowEmpty('quota');

        $validator
            ->numeric('tolerance')
            ->allowEmpty('tolerance');

        return $validator;
    }
}
