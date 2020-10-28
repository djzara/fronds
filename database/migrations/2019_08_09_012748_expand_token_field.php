<?php /** @noinspection ALL */

/** @noinspection ALL */

/** @noinspection PhpUnused */

/** @noinspection PhpUnused */

/** @noinspection PhpCSValidationInspection */

/** @noinspection PhpMethodNamingConventionInspection */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExpandTokenField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('login_verification_tokens', function (Blueprint $table) {
            $table->string('token', 2048)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('login_verification_tokens', function (Blueprint $table) {
           // there's no reason to down this
        });
    }
}
