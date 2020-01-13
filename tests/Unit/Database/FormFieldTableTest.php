<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 19:18
 */

namespace Tests\Unit\Database;


use Fronds\Models\Field;
use Fronds\Models\Form;
use Fronds\Models\FormField;
use Fronds\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class FormFieldTableTest
 * @package Tests\Unit\Database
 */
class FormFieldTableTest extends TestCase
{

    use RefreshDatabase;

    public function testAddFormField(): void
    {
        $formField = factory(FormField::class)->create();
        $this->assertDatabaseHas('form_fields', ['form_id' => $formField->form_id]);
    }

    public function testDeleteFormField(): void
    {
        $formField = factory(FormField::class)->create();
        $this->assertDatabaseHas('form_fields', ['form_id' => $formField->form_id]);
        $formField->delete();
        $this->assertDatabaseMissing('form_fields', ['form_id' => $formField->form_id]);

    }

    public function testHasForm(): void
    {
        $form = factory(Form::class)->create();
        $formField = factory(FormField::class)->create([
            'form_id' => $form->id
        ]);
        $formViaFormField = $formField->form;
        $this->assertEquals($form->id, $formViaFormField->id);
    }

    public function testHasDefinitions(): void
    {
        $field = factory(Field::class)->create();
        $formFields = factory(FormField::class, 3)->create([
            'field_id' => $field->id
        ]);

        foreach ($formFields as $formField) {
            $this->assertEquals($field->id, $formField->definition->id);
        }
    }

    public function testHasUploader(): void
    {
        $user = factory(User::class)->create();
        $formField = factory(FormField::class)->create([
            'owned_by' => $user->id
        ]);
        $this->assertEquals($user->id, $formField->uploader->id);
    }
}
