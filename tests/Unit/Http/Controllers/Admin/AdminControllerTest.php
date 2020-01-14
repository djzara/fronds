<?php

namespace Tests\Unit\Http\Controllers\Admin;

use Fronds\Models\User;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{

    public function testLoginHomeView(): void
    {
        $response = $this->get(route('fronds.admin.home.login'));
        $response->assertOk();
        $response->assertViewIs('admin.auth.login');
    }

    public function testManageViewNoLogin(): void
    {
        $response = $this->get(route('fronds.admin.manage'));
        $response->assertRedirect();
        $response->assertLocation(route('fronds.admin.home.login'));
    }

    public function testManageViewLogin(): void
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get(route('fronds.admin.manage'));
        $response->assertOk();
        $response->assertViewIs('admin.manage');
    }

}
