<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersAddadminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('aki_admin')->default(0);
            $table->dateTime('aki_visited_at')->nullable();
            $table->string('aki_telegram_id')->nullable();
            $table->string('aki_telegram_username')->nullable();
            $table->string('aki_telegram_photo_url')->nullable();
            $table->string('aki_telegram_auth_date')->nullable();
            $table->string('aki_telegram_hash')->nullable();
            $table->string('aki_ip')->nullable();
            $table->text('aki_browser')->nullable();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('aki_visited_at');
            $table->dropColumn('aki_admin');
            $table->dropColumn('aki_telegram_id');
            $table->dropColumn('aki_telegram_username');
            $table->dropColumn('aki_telegram_photo_url');
            $table->dropColumn('aki_telegram_auth_date');
            $table->dropColumn('aki_telegram_hash');
            $table->dropColumn('aki_ip');
            $table->dropColumn('aki_browser');
        });
    }
}
