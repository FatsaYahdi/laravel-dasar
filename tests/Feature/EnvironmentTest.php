<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Env;
use Tests\TestCase;

class EnvironmentTest extends TestCase {
    public function testGetEnv()
    {
        $youtube = env('YOUTUBE');
        self::assertEquals('Landersaki', $youtube);
    }

    public function testDefaultEnv()
    {
        $author = Env::get('AUTHOR','Landersiki');
        self::assertEquals('Landersiki',$author);
    }
}
