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

class CreateLoginVerificationTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_verification_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');
            $table->string('token');
            $table->ipAddress('origin_ip');
            $table->timestamps();
            $table->softDeletes('used_on');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('login_verification_tokens');
    }
}
