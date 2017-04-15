<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssocCarriersInputsFixture
 *
 */
class AssocCarriersInputsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'id_carrier' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id_input' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_assoc_c_ops_carrier_idx' => ['type' => 'index', 'columns' => ['id_carrier'], 'length' => []],
            'FK_assoc_c_input_input_idx' => ['type' => 'index', 'columns' => ['id_input'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_assoc_c_input_carrier' => ['type' => 'foreign', 'columns' => ['id_carrier'], 'references' => ['carriers', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'FK_assoc_c_input_input' => ['type' => 'foreign', 'columns' => ['id_input'], 'references' => ['inputs', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'id_input' => 1
        ],
    ];
}
