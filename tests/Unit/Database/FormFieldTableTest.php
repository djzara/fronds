<?php

declare(strict_types=1);

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
        $formField = FormField::factory()->create();
        $this->assertDatabaseHas('form_fields', ['form_id' => $formField->form_id]);
    }

    public function testDeleteFormField(): void
    {
        $formField = FormField::factory()->create();
        $this->assertDatabaseHas('form_fields', ['form_id' => $formField->form_id]);
        $formField->forceDelete();
        $this->assertDatabaseMissing('form_fields', ['form_id' => $formField->form_id]);
    }

    public function testHasForm(): void
    {
        $form = Form::factory()->create();
        $formField = FormField::factory()->create([
            'form_id' => $form->id
        ]);
        $formViaFormField = $formField->form;
        self::assertEquals($form->id, $formViaFormField->id);
    }

    public function testHasDefinitions(): void
    {
        $field = Field::factory()->create();
        $formFields = FormField::factory()->count(3)->create([
            'field_id' => $field->id
        ]);

        foreach ($formFields as $formField) {
            self::assertEquals($field->id, $formField->definition->id);
        }
    }

    public function testHasUploader(): void
    {
        $user = User::factory()->create();
        $formField = FormField::factory()->create([
            'owned_by' => $user->id
        ]);
        self::assertEquals($user->id, $formField->uploader->id);
    }
}
