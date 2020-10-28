<?php /** @noinspection ALL */

/** @noinspection ALL */

/** @noinspection PhpUnused */

/** @noinspection PhpUnused */

/** @noinspection PhpCSValidationInspection */

/** @noinspection PhpMethodNamingConventionInspection */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id')->index('forms_idx');
            $table->uuid('created_by');
            $table->string('form_link_title', 100);
            $table->string('form_title');
            $table->string('form_description');
            $table->text('form_raw_body')->comment('Pull from RTE');

            $table->boolean('is_published');
            $table->uuid('form_field_id');
            $table->enum('submit_to', ['database', 'mail', 's3', 'csv'])->default('database');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('forms');
    }
}
