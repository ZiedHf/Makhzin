<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InputsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InputsTable Test Case
 */
class InputsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InputsTable
     */
    public $Inputs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.inputs',
        'app.files',
        'app.clients',
        'app.lots',
        'app.products',
        'app.stocks',
        'app.movements',
        'app.categories',
        'app.associations',
        'app.zones',
        'app.outputs',
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
        $config = TableRegistry::exists('Inputs') ? [] : ['className' => 'App\Model\Table\InputsTable'];
        $this->Inputs = TableRegistry::get('Inputs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Inputs);

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
