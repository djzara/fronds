<?php
/**
 * User: zara
 * Date: 2019-02-25
 * Time: 16:32
 */

namespace Tests\Unit\Database;


use Fronds\Models\FrondsSetting;
use Fronds\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PDOException;
use Exception;

class FrondsSettingTableTest extends TestCase
{
    use RefreshDatabase;

    public function testAddFrondsSetting() : void
    {
        $form = factory(FrondsSetting::class)->create();
        $this->assertDatabaseHas('fronds_settings', ['id' => $form->id]);
    }

    /**
     * @throws Exception
     */
    public function testDeleteFrondsSetting() : void
    {
        $frondsSetting = factory(FrondsSetting::class)->create();
        $this->assertDatabaseHas('fronds_settings', ['id' => $frondsSetting->id]);
        $frondsSetting = FrondsSetting::whereId($frondsSetting->id)->first();
        $frondsSetting->delete();
        $this->assertDatabaseMissing('fronds_settings', ['id' => $frondsSetting->id]);
    }

    public function testInvalidFrondsSettingEnum() : void
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionMessageMatches('/^.*(setting_type){1}.*$/');
        factory(FrondsSetting::class)->create([
            'setting_type' => 'invalid'
        ]);
        $this->assertDatabaseMissing('fronds_settings', ['setting_type' => 'invalid']);
    }

    public function testOwner(): void
    {
        $user = factory(User::class)->create();
        $frondsSetting = factory(FrondsSetting::class)->create([
            'owner' => $user->id
        ]);
        $this->assertEquals($user->id, $frondsSetting->ownedBy->id);
    }

}