<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LotsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LotsTable Test Case
 */
class LotsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LotsTable
     */
    public $Lots;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lots',
        'app.products',
        'app.categories',
        'app.stocks',
        'app.movements',
        'app.clients',
        'app.files',
        'app.inputs',
        'app.documents',
        'app.outputs',
        'app.zones'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Lots') ? [] : ['className' => 'App\Model\Table\LotsTable'];
        $this->Lots = TableRegistry::get('Lots', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Lots);

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
