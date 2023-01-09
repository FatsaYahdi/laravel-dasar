<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase {
    public function testInput() {
        $this->get('input/hello?name=asd')->assertSeeText('Hello asd');
        $this->post('input/hello',['name' => 'asd'])->assertSeeText('Hello asd');
    }

    public function testNestedInput() {
        $this->post('/input/hello/first', ['name' => ['first' => 'asd']])->assertSeeText('Hello asd');
    }

    public function testInputAll() {
        $this->post('input/hello/input', ['name' => ['first' => 'lander', 'last' => 'saki']])
            ->assertSeeText('name')->assertSeeText('first')->assertSeeText('lander')
            ->assertSeeText('last')->assertSeeText('saki');
    }

    public function testArrayInput() {
        $this->post('/input/hello/array',[
            'products' => [
                ['name' => 'Bad Apple'],
                ['name' => 'Blue Zenith']
        ]])->assertSeeText('Bad Apple')->assertSeeText('Blue Zenith');
    }

    public function testInputType() {
        $this->post('input/type', [
            'name' => 'asd',
            'birth' => 'true',
            'birth_date' => '2020-12-10'
        ])->assertSeeText('asd')->assertSeeText('true')->assertSeeText('2020-12-10');
    }

    public function testFilterOnly() {
        $this->post('/input/filter/only',[
            'name' => [
                'first' => 'asd',
                'middle' => 'das',
                'last' => 'qwe'
            ]
        ])->assertSeeText('asd')->assertDontSeeText('das')->assertSeeText('asd');
    }

    public function testFilterExcept() {
        $this->post('/input/filter/except',[
            'uname' => 'asd',
            'password' => 'qwe',
            'admin' => 'true'
        ])->assertSeeText('asd')->assertSeeText('qwe')->assertDontSee('admin');
    }

    public function testFilterMerge() {
        $this->post('/input/filter/merge',[
            'uname' => 'asd',
            'password' => 'qwe',
            'admin' => 'true'
        ])->assertSeeText('asd')->assertSeeText('qwe')->assertSeeText('admin')->assertSeeText('false');
    }
}