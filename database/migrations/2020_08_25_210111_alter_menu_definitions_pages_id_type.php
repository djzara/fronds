<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AlterMenuDefinitionsPagesIdType
 *
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class AlterMenuDefinitionsPagesIdType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_definitions_pages', static function (Blueprint $table) {
            $table->uuid('page_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_definitions_pages', static function (Blueprint $table) {
            $table->unsignedBigInteger('page_id')->change();
        });
    }
}
