<?php

declare(strict_types=1);

namespace Tests\Unit\Database;

use Fronds\Models\FrondsSetting;
use Fronds\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PDOException;
use Exception;

/**
 * Class FrondsSettingTableTest
 *
 * @package Tests\Unit\Database
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class FrondsSettingTableTest extends TestCase
{
    use RefreshDatabase;

    public function testAddFrondsSetting() : void
    {
        $form = FrondsSetting::factory()->create();
        $this->assertDatabaseHas('fronds_settings', ['id' => $form->id]);
    }

    /**
     * @throws Exception
     */
    public function testDeleteFrondsSetting() : void
    {
        $frondsSetting = FrondsSetting::factory()->create();
        $this->assertDatabaseHas('fronds_settings', ['id' => $frondsSetting->id]);
        $frondsSetting = FrondsSetting::whereId($frondsSetting->id)->first();
        $frondsSetting->delete();
        $this->assertDatabaseMissing('fronds_settings', ['id' => $frondsSetting->id]);
    }

    public function testInvalidFrondsSettingEnum() : void
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionMessageMatches('/^.*(setting_type){1}.*$/');
        FrondsSetting::factory()->create([
            'setting_type' => 'invalid'
        ]);
        $this->assertDatabaseMissing('fronds_settings', ['setting_type' => 'invalid']);
    }

    public function testOwner(): void
    {
        $user = User::factory()->create();
        $frondsSetting = FrondsSetting::factory()->create([
            'owner' => $user->id
        ]);
        self::assertEquals($user->id, $frondsSetting->ownedBy->id);
    }
}
