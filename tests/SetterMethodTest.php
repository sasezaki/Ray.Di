<?php

declare(strict_types=1);

namespace Ray\Di;

use PHPUnit\Framework\TestCase;
use Ray\Di\Exception\Unbound;

class SetterMethodTest extends TestCase
{
    /**
     * @var SetterMethods
     */
    protected $setterMethods;

    protected function setUp()
    {
        $method = new \ReflectionMethod(FakeCar::class, 'setTires');
        $setterMethod = new SetterMethod($method, new Name(Name::ANY));
        $this->setterMethods = new SetterMethods([$setterMethod]);
    }

    public function testInvoke()
    {
        $container = new Container;
        (new Bind($container, FakeTyreInterface::class))->to(FakeTyre::class);
        $car = new FakeCar(new FakeEngine);
        // setter injection
        $this->setterMethods->__invoke($car, $container);
        $this->assertInstanceOf(FakeTyre::class, $car->frontTyre);
        $this->assertInstanceOf(FakeTyre::class, $car->rearTyre);
        $this->assertNotSame(spl_object_hash($car->frontTyre), spl_object_hash($car->rearTyre));
    }

    public function testUnbound()
    {
        $this->expectException(Unbound::class);
        $container = new Container;
        $car = new FakeCar(new FakeEngine);
        $this->setterMethods->__invoke($car, $container);
    }
}
