<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssocCarriersRvFixture
 *
 */
class AssocCarriersRvFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'assoc_carriers_rv';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'id_carrier' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id_rv' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_assoc_carrier_idx' => ['type' => 'index', 'columns' => ['id_carrier'], 'length' => []],
            'FK_assoc_rv_idx' => ['type' => 'index', 'columns' => ['id_rv'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_assoc_carrier' => ['type' => 'foreign', 'columns' => ['id_carrier'], 'references' => ['carriers', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_assoc_rv' => ['type' => 'foreign', 'columns' => ['id_rv'], 'references' => ['removalvouchers', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'id_carrier' => 1,
            'id_rv' => 1
        ],
    ];
}
