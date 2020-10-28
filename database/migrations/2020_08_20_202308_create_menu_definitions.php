<?php /** @noinspection ALL */

/** @noinspection ALL */

/** @noinspection PhpUnused */

/** @noinspection PhpUnused */

/** @noinspection PhpCSValidationInspection */

/** @noinspection PhpMethodNamingConventionInspection */

/** @noinspection PhpClassNamingConventionInspection */

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateMenuDefinitions
 *
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class CreateMenuDefinitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_definitions', static function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('menu_title');
            $table->enum('menu_type', ['list', 'dropdown'])->default('dropdown');
            $table->boolean('is_hidden');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('menu_definitions');
    }
}
