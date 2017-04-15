<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssociationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssociationsTable Test Case
 */
class AssociationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssociationsTable
     */
    public $Associations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.associations',
        'app.categories',
        'app.products',
        'app.stocks',
        'app.movements',
        'app.lots',
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
        $config = TableRegistry::exists('Associations') ? [] : ['className' => 'App\Model\Table\AssociationsTable'];
        $this->Associations = TableRegistry::get('Associations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Associations);

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
