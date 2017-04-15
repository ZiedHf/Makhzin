<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssocCarriersInputsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssocCarriersInputsTable Test Case
 */
class AssocCarriersInputsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssocCarriersInputsTable
     */
    public $AssocCarriersInputs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.assoc_carriers_inputs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AssocCarriersInputs') ? [] : ['className' => 'App\Model\Table\AssocCarriersInputsTable'];
        $this->AssocCarriersInputs = TableRegistry::get('AssocCarriersInputs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AssocCarriersInputs);

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
}
