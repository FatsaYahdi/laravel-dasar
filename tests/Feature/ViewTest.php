<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase {
    public function testView() {
        $this->get('/hello')->assertSeeText('Hello asd');
        $this->get('/hello1')->assertSeeText('Hello asd');
    }

    public function testNested() {
        $this->get('/hello-world')->assertSeeText('World asd');
    }

    public function testTemplate() {
        $this->view('hello',['name' => 'asd'])->assertSeeText('Hello asd');
        $this->view('hello.world',['name' => 'asd'])->assertSeeText('World asd');
    }
}
