<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testDependency() {
        $foo = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);

        self::assertEquals("Foo", $foo->foo());
        self::assertEquals("Foo", $foo2->foo());
        // self::assertNotSame($foo,$foo2);
    }

    public function testBind() {
        $this->app->bind(Person::class, function ($app) {
            return new Person('FirstName', 'LastName');
        });

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);
        self::assertNotNull("FirstName", $person1->firstName);
        self::assertNotNull("FirstName", $person2->firstName);
        self::assertNotSame($person1, $person2);
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function($app) {
            return new Person('FirstName', 'LastName');
        });

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class); 
        self::assertEquals("FirstName", $person2->firstName);
        self::assertEquals("FirstName", $person2->firstName);
        self::assertSame($person1, $person2);
    }

    public function testInstance()
    {
        $person = new Person('FirstName', 'LastName');
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertEquals('FirstName',$person1->firstName);
        self::assertEquals('FirstName',$person2->firstName);
        self::assertSame($person, $person1);
        self::assertSame($person1, $person2);
    }

    public function testDependencyInjection()
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar1->foo);
        // self::assertNotSame($bar1, $bar2);
    }

    public function testDependencyInjectionInClosure() {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app) {
            return new Bar($app->make(Foo::class));
        });

        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);
        self::assertSame($bar1, $bar2);
    }

    public function testInterfaceToClass() {
        // $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);
        $this->app->singleton(HelloService::class, function ($app) {
            return new HelloServiceIndonesia();
        });
        $helloService = $this->app->make(HelloService::class);
        self::assertEquals('Halo nama', $helloService->hello('nama'));
    }

}


