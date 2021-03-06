<?php

/*@description        Dice - A minimal Dependency Injection Container for PHP
* @author             Tom Butler tom@r.je
* @copyright          2012-2015 Tom Butler <tom@r.je>
* @link               http://r.je/dice.html
* @license            http://www.opensource.org/licenses/bsd-license.php  BSD License
* @version            2.0
*/

class ShareInstancesTest extends DiceTest
{
    public function testShareInstances()
    {
        $rule = [];
        $rule['shareInstances'] = ['Shared'];
        $this->dice->addRule('TestSharedInstancesTop', $rule);


        $shareTest = $this->dice->create('TestSharedInstancesTop');

        $this->assertinstanceOf('TestSharedInstancesTop', $shareTest);

        $this->assertInstanceOf('SharedInstanceTest1', $shareTest->share1);
        $this->assertInstanceOf('SharedInstanceTest2', $shareTest->share2);

        $this->assertSame($shareTest->share1->shared, $shareTest->share2->shared);
        $this->assertEquals($shareTest->share1->shared->uniq, $shareTest->share2->shared->uniq);

    }

    public function testNamedShareInstances()
    {

        $rule = [];
        $rule['instanceOf'] = 'Shared';
        $this->dice->addRule('$Shared', $rule);

        $rule = [];
        $rule['shareInstances'] = ['$Shared'];
        $this->dice->addRule('TestSharedInstancesTop', $rule);


        $shareTest = $this->dice->create('TestSharedInstancesTop');

        $this->assertinstanceOf('TestSharedInstancesTop', $shareTest);

        $this->assertInstanceOf('SharedInstanceTest1', $shareTest->share1);
        $this->assertInstanceOf('SharedInstanceTest2', $shareTest->share2);

        $this->assertSame($shareTest->share1->shared, $shareTest->share2->shared);
        $this->assertEquals($shareTest->share1->shared->uniq, $shareTest->share2->shared->uniq);


        $shareTest2 = $this->dice->create('TestSharedInstancesTop');
        $this->assertNotSame($shareTest2->share1->shared, $shareTest->share2->shared);
    }


    public function testShareInstancesNested()
    {
        $rule = [];
        $rule['shareInstances'] = ['F'];
        $this->dice->addRule('A4', $rule);
        $a = $this->dice->create('A4');
        $this->assertTrue($a->m1->f === $a->m2->e->f);
    }


    public function testShareInstancesMultiple()
    {
        $rule = [];
        $rule['shareInstances'] = ['Shared'];
        $this->dice->addRule('TestSharedInstancesTop', $rule);


        $shareTest = $this->dice->create('TestSharedInstancesTop');

        $this->assertinstanceOf('TestSharedInstancesTop', $shareTest);

        $this->assertInstanceOf('SharedInstanceTest1', $shareTest->share1);
        $this->assertInstanceOf('SharedInstanceTest2', $shareTest->share2);

        $this->assertSame($shareTest->share1->shared, $shareTest->share2->shared);
        $this->assertEquals($shareTest->share1->shared->uniq, $shareTest->share2->shared->uniq);


        $shareTest2 = $this->dice->create('TestSharedInstancesTop');
        $this->assertSame($shareTest2->share1->shared, $shareTest2->share2->shared);
        $this->assertEquals($shareTest2->share1->shared->uniq, $shareTest2->share2->shared->uniq);

        $this->assertNotSame($shareTest->share1->shared, $shareTest2->share2->shared);
        $this->assertNotEquals($shareTest->share1->shared->uniq, $shareTest2->share2->shared->uniq);

    }
}
