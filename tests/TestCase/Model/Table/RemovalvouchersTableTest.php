<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RemovalvouchersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RemovalvouchersTable Test Case
 */
class RemovalvouchersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RemovalvouchersTable
     */
    public $Removalvouchers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.removalvouchers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Removalvouchers') ? [] : ['className' => 'App\Model\Table\RemovalvouchersTable'];
        $this->Removalvouchers = TableRegistry::get('Removalvouchers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Removalvouchers);

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
