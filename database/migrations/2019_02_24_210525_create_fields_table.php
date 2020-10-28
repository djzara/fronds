<?php /** @noinspection ALL */

/** @noinspection ALL */

/** @noinspection PhpUnused */

/** @noinspection PhpUnused */

/** @noinspection PhpCSValidationInspection */

/** @noinspection PhpMethodNamingConventionInspection */

/** @noinspection PhpClassNamingConventionInspection */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('field_label');
            $table->string('field_markup_id')->nullable();
            $table->enum('field_type', [
                'text',
                'email',
                'number',
                'currency',
                'dropdown',
                'radio',
                'checkbox'
            ]);
            $table->string('field_hint');

            $table->timestamps();
            $table->softDeletes();
            $table->unique('field_markup_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}
