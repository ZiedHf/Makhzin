<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OutputsFixture
 *
 */
class OutputsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'qte' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'lot_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'file_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'outputSet_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'FK_outputs_lots_idx' => ['type' => 'index', 'columns' => ['lot_id'], 'length' => []],
            'FK_outputs_files_idx' => ['type' => 'index', 'columns' => ['file_id'], 'length' => []],
            'FK_outputs_outputSets_idx' => ['type' => 'index', 'columns' => ['outputSet_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_outputs_files' => ['type' => 'foreign', 'columns' => ['file_id'], 'references' => ['files', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_outputs_lots' => ['type' => 'foreign', 'columns' => ['lot_id'], 'references' => ['lots', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_outputs_outputSets' => ['type' => 'foreign', 'columns' => ['outputSet_id'], 'references' => ['outputsets', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'date' => '2016-05-17 08:57:08',
            'qte' => 1,
            'lot_id' => 1,
            'file_id' => 1,
            'outputSet_id' => 1,
            'created' => '2016-05-17 08:57:08',
            'modified' => '2016-05-17 08:57:08'
        ],
    ];
}
