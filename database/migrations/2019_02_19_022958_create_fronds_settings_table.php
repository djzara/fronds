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

class CreateFrondsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fronds_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('setting_name');
            $table->string('setting_value')->nullable();
            $table->boolean('setting_switch')->default(false);
            $table->timestamp('setting_time')->default(\Carbon\Carbon::now());
            $table->enum('setting_type', ['text', 'switch', 'time']);
            $table->uuid('owner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fronds_settings');
    }
}
