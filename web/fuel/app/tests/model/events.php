<?php

/**
 * @group App
 * @group AppModel
 */
class Test_Events extends DbTestCase
{
 
    protected function tearDown()
    {
        parent::tearDown();
    }

    protected $tables = array(
        'events' => 'events'
    );

    public function test_cancelable()
    {
        $mock = $this->getStaticMock('Events', array('getNow'));
        $mock->staticExpects($this->any())
            ->method('getNow')
            ->will($this->returnValue("this is mock value"))
        ;

       print Events::getNow();
    }
}
