<?php
namespace App\Model\Table;

use App\Model\Entity\Product;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Stocks
 * @property \Cake\ORM\Association\HasMany $Associations
 * @property \Cake\ORM\Association\HasMany $Lots
 * @property \Cake\ORM\Association\HasMany $Stocks
 */
class ProductsTable extends Table
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

        $this->table('products');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Stocks', [
            'foreignKey' => 'stock_id'
        ]);
        $this->belongsTo('Zones', [
            'foreignKey' => 'zone_id'
        ]);
        $this->belongsToMany('Categories', [
            'joinTable' => 'Associations',
        ]);
        $this->hasMany('Lots', [
            'foreignKey' => 'product_id'
        ]);
        /*$this->hasMany('Stocks', [
            'foreignKey' => 'product_id'
        ]);*/
        $this->hasOne('Stocks', [
            'foreignKey' => 'product_id'
        ]);
        /*$this->hasMany('Zones', [
            'foreignKey' => 'zone_id'
        ]);*/
        $this->belongsTo('Users_CreatedBy', [
            'className' => 'Users',
            'foreignKey' => 'created_by'
        ]);
        $this->belongsTo('Users_ModifiedBy', [
            'className' => 'Users',
            'foreignKey' => 'modified_by'
        ]);
        $this->belongsTo('productstates', [
            'foreignKey' => 'productState_id'
        ]);
        $this->belongsTo('Packagings', [
            'foreignKey' => 'packaging_id'
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
            ->requirePresence('productCode', 'create')
            ->notEmpty('productCode');

        $validator
            ->requirePresence('ngpCode', 'create')
            ->notEmpty('ngpCode');

        $validator
            ->requirePresence('barCode', 'create')
            ->notEmpty('barCode');

        $validator
            ->boolean('subjectToQuota')
            ->requirePresence('subjectToQuota', 'create')
            ->notEmpty('subjectToQuota');

        $validator
            ->numeric('quota')
            ->requirePresence('quota', 'create')
            ->allowEmpty('quota');
        
        /*$validator
            ->boolean('quotaConsidered')
            ->requirePresence('quotaConsidered', 'create')
            ->allowEmpty('quotaConsidered');*/

        $validator
            ->numeric('tolerance')
            ->allowEmpty('tolerance');

        $validator
            ->boolean('approved')
            ->allowEmpty('approved');

        /*$validator
            ->allowEmpty('emballage');*/

        $validator
            ->numeric('unitQte')
            ->allowEmpty('unitQte');

        $validator
            ->allowEmpty('unit');
        
        $validator
            ->requirePresence('productState_id')
            ->notEmpty('productState_id', 'Merci de choisir l\'état de produit');
        
        $validator
            ->requirePresence('packaging_id')
            ->notEmpty('packaging_id', 'Merci de choisir l\'emballage');
        
        $validator
            ->allowEmpty('description_product')
            ->add('desc', [
                'length' => [
                    'rule' => ['maxLength', 5000],
                    'message' => 'La description ne peut pas dépasser 5000 caractères',
                ]
            ]);

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
        $rules->add($rules->existsIn(['zone_id'], 'Zones'));
        return $rules;
    }
}
