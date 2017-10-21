<?php
namespace App\Model\Table;

use App\Model\Entity\Category;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Categories Model
 *
 * @property \Cake\ORM\Association\HasMany $Associations
 */
class CategoriesTable extends Table
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

        $this->table('categories');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        /*$this->hasMany('Associations', [
            'foreignKey' => 'category_id'
        ]);*/
        /*$this->hasMany('Dependencies1', [
            'foreignKey' => 'id_category1',
            'className' => 'Dependencies'
        ]);
        $this->hasMany('Dependencies2', [
            'foreignKey' => 'id_category2',
            'className' => 'Dependencies'
        ]);*/
        
        $this->belongsToMany('Products', [
            'joinTable' => 'Associations',
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
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
            ->add('name', [
            'length' => [
                'rule' => ['maxLength', 255],
                'message' => 'Le nom ne peut pas dépasser 255 caractères',
            ]])
            ->notEmpty('name');
        $validator
            ->requirePresence('quota');
        $validator
            ->allowEmpty('description_categ')
            ->add('desc', [
                'length' => [
                    'rule' => ['maxLength', 5000],
                    'message' => 'La description ne peut pas dépasser 5000 caractères',
                ]
            ]);
        
        return $validator;
    }
}
