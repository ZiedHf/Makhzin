<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OutputsetsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OutputsetsTable Test Case
 */
class OutputsetsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OutputsetsTable
     */
    public $Outputsets;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.outputsets',
        'app.files',
        'app.clients',
        'app.lots',
        'app.products',
        'app.stocks',
        'app.movements',
        'app.categories',
        'app.associations',
        'app.zones',
        'app.inputs',
        'app.outputs',
        'app.providers',
        'app.documents'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Outputsets') ? [] : ['className' => 'App\Model\Table\OutputsetsTable'];
        $this->Outputsets = TableRegistry::get('Outputsets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Outputsets);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
