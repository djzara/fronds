<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 18:17
 */

namespace Tests\Unit\Database;


use Fronds\Models\Field;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FieldTableTest extends TestCase
{

    use RefreshDatabase;

    public function testAddField() : void {
        $field = factory(Field::class)->create();
        $this->assertDatabaseHas('fields', ['id' => $field->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteField() : void {
        $field = factory(Field::class)->create();
        $this->assertDatabaseHas('fields', ['id' => $field->id]);
        $fieldToDelete = Field::whereId($field->id)->first();
        $fieldToDelete->delete();
        $this->assertDatabaseMissing('fields', ['deleted_at' => null, 'id' => $fieldToDelete->id]);
        $fieldToDelete->forceDelete();
        $this->assertDatabaseMissing('fields', ['id' => $fieldToDelete->id]);
    }
}