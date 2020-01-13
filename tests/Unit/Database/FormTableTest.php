<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 19:25
 */

namespace Tests\Unit\Database;


use Fronds\Models\Field;
use Fronds\Models\Form;
use Fronds\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormTableTest extends TestCase
{

    use RefreshDatabase;

    public function testAddForm(): void
    {
        $form = factory(Form::class)->create();
        $this->assertDatabaseHas('forms', ['id' => $form->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteForm(): void
    {
        $form = factory(Form::class)->create();
        $this->assertDatabaseHas('forms', ['id' => $form->id]);
        $form = Form::whereId($form->id)->first();
        $form->delete();
        $this->assertDatabaseMissing('forms', ['deleted_at' => null, 'id' => $form->id]);
        $form->forceDelete();
        $this->assertDatabaseMissing('forms', ['id' => $form->id]);
    }

    public function testCreator(): void
    {
        $user = factory(User::class)->create();
        $form = factory(Form::class)->create([
            'created_by' => $user
        ]);
        $this->assertEquals($user->id, $form->creator->id);
    }

    public function testFields(): void
    {
        $form = factory(Form::class)->create();
        factory(Field::class, 3)->create()->each(static function ($field) use ($form) {
            $field->forms()->attach($form->id, ['field_value' => 'some value']);
        });

        $this->assertCount(3, $form->fields);
    }
}
