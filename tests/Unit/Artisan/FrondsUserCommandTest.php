<?php
/**
 * User: zara
 * Date: 2019-05-08
 * Time: 19:15
 */

namespace Tests\Unit\Artisan;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrondsUserCommandTest extends TestCase
{

    use RefreshDatabase;

    public function testCreateUserValid() : void
    {
        $this->artisan('fronds:user')
            ->expectsOutput('Creating a Fronds user...')
        ->expectsQuestion('Name?', 'Fronds Tester')
        ->expectsQuestion('Email?', 'fronds@fronds.com')
        ->expectsQuestion('Password?', 'foo')
        ->assertExitCode(0);
    }

    public function testCreateUserFunctions() : void
    {
        $this->artisan('fronds:user')
            ->expectsQuestion('Name?', 'Fronds Test')
            ->expectsQuestion('Email?', 'fronds@test.com')
            ->expectsQuestion('Password?', 'foo')
            ->execute();

        $this->assertDatabaseHas('users', [
            'name' => 'Fronds Test',
            'email' => 'fronds@test.com'
        ]);
    }
}