<?php

/** @noinspection ALL */

/** @noinspection ALL */

/** @noinspection PhpUnused */

/** @noinspection PhpUnused */

/** @noinspection PhpCSValidationInspection */

/** @noinspection PhpMethodNamingConventionInspection */

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddUniqueNameColumnToMenuDefinitions
 *
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class AddUniqueNameColumnToMenuDefinitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_definitions', static function (Blueprint $table) {
            $table->string('reference_name')->after('uuid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_definitions', static function (Blueprint $table) {
            $table->dropColumn('reference_name');
        });
    }
}
