<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssocCarriersRvTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssocCarriersRvTable Test Case
 */
class AssocCarriersRvTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssocCarriersRvTable
     */
    public $AssocCarriersRv;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.assoc_carriers_rv'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AssocCarriersRv') ? [] : ['className' => 'App\Model\Table\AssocCarriersRvTable'];
        $this->AssocCarriersRv = TableRegistry::get('AssocCarriersRv', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AssocCarriersRv);

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
