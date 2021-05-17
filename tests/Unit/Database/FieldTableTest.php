<?php

declare(strict_types=1);
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 18:17
 */

namespace Tests\Unit\Database;

use Fronds\Models\Field;
use Fronds\Models\Form;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class FieldTableTest
 *
 * @package Tests\Unit\Database
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class FieldTableTest extends TestCase
{

    use RefreshDatabase;

    public function testAddField(): void
    {
        $field = Field::factory()->create();
        $this->assertDatabaseHas('fields', ['id' => $field->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteField(): void
    {
        $field = Field::factory()->create();
        $this->assertDatabaseHas('fields', ['id' => $field->id]);
        $field->delete();
        $this->assertDatabaseMissing('fields', ['deleted_at' => null, 'id' => $field->id]);
        $field->forceDelete();
        $this->assertDatabaseMissing('fields', ['id' => $field->id]);
    }

    public function testForms(): void
    {
        $field = Field::factory()->create();
        Form::factory()->count(3)->create()->each(static function ($form) use ($field) {
            $form->fields()->attach($field->id, ['field_value' => 'some value']);
        });

        self::assertCount(3, $field->forms);
    }
}
