<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 19:25
 */

namespace Tests\Unit\Database;


use Fronds\Models\Form;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormTableTest extends TestCase
{
    
    use RefreshDatabase;

    public function testAddForm() : void {
        $form = factory(Form::class)->create();
        $this->assertDatabaseHas('forms', ['id' => $form->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteForm() : void {
        $form = factory(Form::class)->create();
        $this->assertDatabaseHas('forms', ['id' => $form->id]);
        $formToDelete = Form::whereId($form->id)->first();
        $formToDelete->delete();
        $this->assertDatabaseMissing('forms', ['deleted_at' => null, 'id' => $formToDelete->id]);
        $formToDelete->forceDelete();
        $this->assertDatabaseMissing('forms', ['id' => $formToDelete->id]);
    }
}