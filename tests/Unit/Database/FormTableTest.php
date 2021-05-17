<?php

declare(strict_types=1);


namespace Tests\Unit\Database;

use Fronds\Models\Field;
use Fronds\Models\Form;
use Fronds\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class FormTableTest
 *
 * @package Tests\Unit\Database
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class FormTableTest extends TestCase
{

    use RefreshDatabase;

    public function testAddForm(): void
    {
        $form = Form::factory()->create();
        $this->assertDatabaseHas('forms', ['id' => $form->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteForm(): void
    {
        $form = Form::factory()->create();
        $this->assertDatabaseHas('forms', ['id' => $form->id]);
        $form = Form::whereId($form->id)->first();
        $form->delete();
        $this->assertDatabaseMissing('forms', ['deleted_at' => null, 'id' => $form->id]);
        $form->forceDelete();
        $this->assertDatabaseMissing('forms', ['id' => $form->id]);
    }

    public function testCreator(): void
    {
        $user = User::factory()->create();
        $form = Form::factory()->create([
            'created_by' => $user
        ]);
        self::assertEquals($user->id, $form->creator->id);
    }

    public function testFields(): void
    {
        $form = Form::factory()->create();
        Field::factory()->count(3)->create()->each(static function ($field) use ($form) {
            $field->forms()->attach($form->id, ['field_value' => 'some value']);
        });

        self::assertCount(3, $form->fields);
    }
}
