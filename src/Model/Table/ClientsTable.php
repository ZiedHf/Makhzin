<?php
namespace App\Model\Table;

use App\Model\Entity\Client;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clients Model
 *
 * @property \Cake\ORM\Association\HasMany $Files
 * @property \Cake\ORM\Association\HasMany $Lots
 */
class ClientsTable extends Table
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

        $this->table('clients');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Files', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('Lots', [
            'foreignKey' => 'client_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('matriculeFiscale');

        $validator
            ->allowEmpty('code');

        $validator
            ->boolean('approved')
            ->allowEmpty('approved');

        $validator
            ->allowEmpty('adress');

        $validator
            ->allowEmpty('email1');

        $validator
            ->allowEmpty('email2');

        $validator
            ->allowEmpty('email3');

        $validator
            ->allowEmpty('tel1');

        $validator
            ->allowEmpty('tel2');

        $validator
            ->allowEmpty('tel3');

        $validator
            ->allowEmpty('fax1');

        $validator
            ->allowEmpty('fax2');

        $validator
            ->allowEmpty('fax3');

        return $validator;
    }
}
