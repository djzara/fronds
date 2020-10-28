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

/**
 * Class RekeyFormFieldsPrimary
 */
class RekeyFormFieldsPrimary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_fields', static function (Blueprint $table) {
            $table->dropPrimary(['form_id']);
        });
        Schema::table('form_fields', static function (Blueprint $table) {
            $table->increments('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_fields', static function (Blueprint $table) {
            $table->dropPrimary();
        });
        Schema::table('form_fields', static function (Blueprint $table) {
            $table->primary('form_id');
        });
    }
}
