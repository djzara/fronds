<?php
/**
 * User: zara
 * Date: 2019-02-25
 * Time: 16:32
 */

namespace Tests\Unit\Database;


use Fronds\Models\FrondsSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrondsSettingTableTest extends TestCase
{
    use RefreshDatabase;

    public function testAddFrondsSetting() : void {
        $form = factory(FrondsSetting::class)->create();
        $this->assertDatabaseHas('fronds_settings', ['id' => $form->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteFrondsSetting() : void {
        $frondsSetting = factory(FrondsSetting::class)->create();
        $this->assertDatabaseHas('fronds_settings', ['id' => $frondsSetting->id]);
        $frondsSettingToDelete = FrondsSetting::whereId($frondsSetting->id)->first();
        $frondsSettingToDelete->delete();
        $this->assertDatabaseMissing('fronds_settings', ['id' => $frondsSettingToDelete->id]);
    }

    /**
     * @expectedException \PDOException
     * @expectedExceptionMessageRegExp /^.*(setting_type){1}.*$/
     */
    public function testInvalidFrondsSettingEnum() : void {
        factory(FrondsSetting::class)->create([
            'setting_type' => 'invalid'
        ]);
        $this->assertDatabaseMissing('fronds_settings', ['setting_type' => 'invalid']);
    }

}