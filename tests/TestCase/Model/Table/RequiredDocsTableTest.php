<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RequiredDocsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RequiredDocsTable Test Case
 */
class RequiredDocsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RequiredDocsTable
     */
    public $RequiredDocs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.required_docs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RequiredDocs') ? [] : ['className' => 'App\Model\Table\RequiredDocsTable'];
        $this->RequiredDocs = TableRegistry::get('RequiredDocs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RequiredDocs);

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
