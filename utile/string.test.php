<?php

/**
 * Test class for HackJob_Utile_String.
 * Generated by PHPUnit on 2011-03-23 at 21:09:54.
 */
class HackJob_Utile_StringTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HackJob_Utile_String
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new HackJob_Utile_String('HackJob\'s quite awesome! äüöß %');
    }
    
    public function testGetString()
    {
    	$this->assertEquals(
    		'HackJob\'s quite awesome! äüöß %',
    		$this->object->getString());
    }
    
    public function testToString()
    {
    	$this->assertEquals((string)$this->object, $this->object->getString());
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @todo Implement testToSlug().
     */
    public function testToSlug()
    {
        $this->object->toSlug();
        $this->assertEquals('hackjob-s-quite-awesome', $this->object->getString());
    }
}
?>
