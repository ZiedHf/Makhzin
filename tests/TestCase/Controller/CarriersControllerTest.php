<?php
namespace App\Test\TestCase\Controller;

use App\Controller\CarriersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\CarriersController Test Case
 */
class CarriersControllerTest extends IntegrationTestCase
{

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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
