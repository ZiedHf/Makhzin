<?php
namespace App\Model\Table;

use App\Model\Entity\Dependency;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Dependencies Model
 *
 */
class DependenciesTable extends Table
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

        $this->table('dependencies');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        
        $this->belongsTo('Categories', [
            'foreignKey' => 'id_category1',
            'className' => 'Categories'
        ]);
        $this->belongsTo('Categories2', [
            'foreignKey' => 'id_category2',
            'className' => 'Categories' 
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
            ->integer('id_category1')
            ->requirePresence('id_category1', 'create')
            ->notEmpty('id_category1');

        $validator
            ->integer('id_category2')
            ->requirePresence('id_category2', 'create')
            ->notEmpty('id_category2');

        $validator
            ->numeric('quota')
            ->allowEmpty('quota');

        return $validator;
    }
}
