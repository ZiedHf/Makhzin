<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductstatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductstatesTable Test Case
 */
class ProductstatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductstatesTable
     */
    public $Productstates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.productstates'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Productstates') ? [] : ['className' => 'App\Model\Table\ProductstatesTable'];
        $this->Productstates = TableRegistry::get('Productstates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Productstates);

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
