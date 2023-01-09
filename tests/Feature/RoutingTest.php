<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet() {
        $this->get('/asd')->assertStatus(200)->assertSeeText('Hola asd');
    }
    public function testRedirect() {
        $this->get('/yt')->assertRedirect('/asd');
    }
    public function testFallback() {
        $this->get('/sad')->assertSeeText('Jir kosong');
    }

    public function testRouteParameter() {
        $this->get('/products/1')->assertSeeText('Product : 1');
        $this->get('/products/2')->assertSeeText('Product : 2');
        $this->get('/products/1/items/XXX')->assertSeeText('Product : 1, Items : XXX');
        $this->get('/products/2/items/YYY')->assertSeeText('Product : 2, Items : YYY');
    }

    public function testRouteParameterRegex() {
        $this->get('/categories/12')->assertSeeText('Category : 12');
        $this->get('/categories/asd')->assertSeeText('Jir kosong');
    }

    public function testRouteOptionalParameter() {
        $this->get('/users/1')->assertSeeText('User : 1');
        $this->get('/users/')->assertSeeText('User : 404');
    }

    public function testRouteConflict() {
        $this->get('/conflict/awok')->assertSeeText('Conflict awok');
        $this->get('/conflict/asd')->assertSeeText('Conflict asd');
    }

    public function testNamedRoute() {
        $this->get('/produk/123')->assertSeeText('products/123');
        $this->get('/produk-redirect/123')->assertRedirect('products/123');
    }
}
