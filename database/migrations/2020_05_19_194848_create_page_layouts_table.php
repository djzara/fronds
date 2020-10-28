<?php /** @noinspection ALL */

/** @noinspection ALL */

/** @noinspection PhpUnused */

/** @noinspection PhpUnused */

/** @noinspection PhpCSValidationInspection */

/** @noinspection PhpMethodNamingConventionInspection */

/** @noinspection PhpClassNamingConventionInspection */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_layouts', static function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('layout_name');
            $table->smallInteger('columns', false, true);
            $table->integer('width')->unsigned();
            $table->boolean('supports_actions')->default(true);
            $table->unsignedSmallInteger('max_actions')->nullable();
            $table->enum('units', ['px', 'rem', 'em']);
            $table->uuid('created_by');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['id', 'uuid']);
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_layouts');
    }
}
