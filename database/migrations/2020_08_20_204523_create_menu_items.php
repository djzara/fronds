<?php /** @noinspection ALL */

/** @noinspection ALL */

/** @noinspection PhpUnused */

/** @noinspection PhpUnused */

/** @noinspection PhpCSValidationInspection */

/** @noinspection PhpMethodNamingConventionInspection */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateMenuItems
 *
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class CreateMenuItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', static function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->enum('direct_to', ['external', 'page']);
            $table->text('external_link')->nullable();
            $table->uuid('page_id')->nullable();
            $table->string('label');
            $table->string('field_id')->nullable();
            $table->integer('list_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('menu_definition_id')->references('id')->on('menu_definitions');
            $table->index(['id', 'uuid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('menu_items');
        Schema::enableForeignKeyConstraints();
    }
}
