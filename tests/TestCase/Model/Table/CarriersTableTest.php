<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CarriersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CarriersTable Test Case
 */
class CarriersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CarriersTable
     */
    public $Carriers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.carriers',
        'app.inputs',
        'app.files',
        'app.clients',
        'app.lots',
        'app.products',
        'app.stocks',
        'app.movements',
        'app.users__created_by',
        'app.users__modified_by',
        'app.zones',
        'app.categories',
        'app.associations',
        'app.product_states',
        'app.packagings',
        'app.outputs',
        'app.outputsets',
        'app.providers',
        'app.documents',
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
        $config = TableRegistry::exists('Carriers') ? [] : ['className' => 'App\Model\Table\CarriersTable'];
        $this->Carriers = TableRegistry::get('Carriers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Carriers);

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
