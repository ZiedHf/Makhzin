<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Model
 *
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->notEmpty('role')
            ->add('role', 'inList', [
                'rule' => ['inList', ['admin', 'magasinier', 'douanier', 'membre']],
                'message' => 'Please enter a valid role'
            ]);
        $validator
            ->integer('products')
            ->allowEmpty('products');

        $validator
            ->integer('categories')
            ->allowEmpty('categories');

        $validator
            ->integer('providers')
            ->allowEmpty('providers');

        $validator
            ->integer('stocks')
            ->allowEmpty('stocks');

        $validator
            ->integer('movements')
            ->allowEmpty('movements');

        $validator
            ->integer('clients')
            ->allowEmpty('clients');

        $validator
            ->integer('lots')
            ->allowEmpty('lots');

        $validator
            ->integer('zones')
            ->allowEmpty('zones');

        $validator
            ->integer('files')
            ->allowEmpty('files');

        $validator
            ->integer('inputs')
            ->allowEmpty('inputs');

        $validator
            ->integer('documents')
            ->allowEmpty('documents');

        $validator
            ->integer('outputSets')
            ->allowEmpty('outputSets');

        $validator
            ->integer('required_docs')
            ->allowEmpty('required_docs');

        $validator
            ->integer('outputs')
            ->allowEmpty('outputs');
        $validator
            ->integer('users')
            ->allowEmpty('users');
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
        $rules->add($rules->isUnique(['username']));
        return $rules;
    }
    
    public function validationPassword(Validator $validator )
    {

        $validator
            ->add('password_old','custom',[
                'rule'=>  function($value, $context){
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                            return true;
                        }
                    }
                    return false;
                },
                'message'=>'Mot de passe incorrect !',
            ])
            ->notEmpty('password_old');

        $validator
            ->add('password_new', [
                'length' => [
                    'rule' => ['minLength', 1],
                    'message' => 'Merci de saisir un mot de passe valide !',
                ]
            ])
            ->add('password_new',[
                'match'=>[
                    'rule'=> ['compareWith','password_new2'],
                    'message'=>'The passwords does not match!',
                ]
            ])
            ->notEmpty('password_new');
        $validator
            ->add('password_new2', [
                'length' => [
                    'rule' => ['minLength', 1],
                    'message' => 'Merci de saisir un mot de passe valide !',
                ]
            ])
            ->add('password_new2',[
                'match'=>[
                    'rule'=> ['compareWith','password_new'],
                    'message'=>'mot de passe ne correspond pas !',
                ]
            ])
            ->notEmpty('password_new2');

        return $validator;
    }
}
