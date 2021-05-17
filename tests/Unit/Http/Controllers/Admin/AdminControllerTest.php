<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Admin;

use Fronds\Models\User;
use Tests\TestCase;

/**
 * Class AdminControllerTest
 *
 * @package Tests\Unit\Http\Controllers\Admin
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
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
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('fronds.admin.manage'));
        $response->assertOk();
        $response->assertViewIs('admin.manage');
    }

}
