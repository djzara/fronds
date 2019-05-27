<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 19:18
 */

namespace Tests\Unit\Database;


use Fronds\Models\FormField;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormFieldTableTest extends TestCase
{

    use RefreshDatabase;
    
    public function testAddFormField() : void {
        $formField = factory(FormField::class)->create();
        $this->assertDatabaseHas('form_fields', ['form_id' => $formField->form_id]);
    }

    /**
     * @throws \Exception
     * TODO: this test will be updated big time once relationships are implemented
     */
    public function testDeleteFormField() : void {
        $formField = factory(FormField::class)->create();
        $this->assertDatabaseHas('form_fields', ['form_id' => $formField->form_id]);
        $formFieldToDelete = FormField::whereFormId($formField->form_id)->first();
        $formFieldToDelete->delete();
        $this->assertDatabaseMissing('form_fields', ['form_id' => $formFieldToDelete->form_id]);

    }
}