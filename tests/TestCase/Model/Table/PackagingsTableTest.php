<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PackagingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PackagingsTable Test Case
 */
class PackagingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PackagingsTable
     */
    public $Packagings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.packagings'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Packagings') ? [] : ['className' => 'App\Model\Table\PackagingsTable'];
        $this->Packagings = TableRegistry::get('Packagings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Packagings);

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
