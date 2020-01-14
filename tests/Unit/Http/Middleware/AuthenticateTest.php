<?php

namespace Tests\Unit\Http\Middleware;

use Tests\TestCase;

class AuthenticateTest extends TestCase
{

    public function testInvalidUserRedirect(): void
    {
        $response = $this->get(route('fronds.admin.manage'));
        $response->assertRedirect(route('fronds.admin.home.login'));
    }
}
