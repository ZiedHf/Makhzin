<?php
namespace App\Model\Table;

use App\Model\Entity\Stock;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Stocks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Products
 * @property \Cake\ORM\Association\HasMany $Movements
 * @property \Cake\ORM\Association\HasMany $Products
 */
class StocksTable extends Table
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

        $this->table('stocks');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id'
        ]);
        $this->hasMany('Movements', [
            'foreignKey' => 'stock_id'
        ]);
        $this->hasOne('Products', [
            'foreignKey' => 'stock_id'
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
            ->numeric('amount')
            ->allowEmpty('amount');

        $validator
            ->numeric('unitQte')
            ->allowEmpty('unitQte');

        $validator
            ->allowEmpty('unit');

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
        return $rules;
    }
}
