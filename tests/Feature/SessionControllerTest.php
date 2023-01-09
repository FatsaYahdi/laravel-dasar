<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase {
    public function testCreateSession() {
        $this->get('/session/create')
            ->assertSeeText('OK')
            ->assertSessionHas('userId', 'kekw')
            ->assertSessionHas('isMember','true');
    }

    public function testGetSession() {
        $this->withSession(['userId' => 'kekw', 'isMember' => 'true'])
            ->get('/session/get')
            ->assertSeeText("User Id : kekw, Is Member : true");
    }

    public function testGetSessionFailed() {
        $this->withSession([])
            ->get('/session/get')
            ->assertSeeText("User Id : guest, Is Member : false");
    }
}
