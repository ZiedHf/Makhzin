<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OutputsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OutputsTable Test Case
 */
class OutputsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OutputsTable
     */
    public $Outputs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.outputs',
        'app.lots',
        'app.products',
        'app.stocks',
        'app.movements',
        'app.categories',
        'app.associations',
        'app.clients',
        'app.files',
        'app.providers',
        'app.documents',
        'app.inputs',
        'app.zones',
        'app.outputsets'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Outputs') ? [] : ['className' => 'App\Model\Table\OutputsTable'];
        $this->Outputs = TableRegistry::get('Outputs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Outputs);

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
