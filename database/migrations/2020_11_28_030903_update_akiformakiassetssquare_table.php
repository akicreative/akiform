<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAkiformakiassetssquareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('akiform_assets', function (Blueprint $table) {
            $table->string('serverfilenamesq')->nullable()->after('serverfilenametn');
            
        });

        Schema::table('akiform_categories', function (Blueprint $table) {
            $table->integer('assetsqw')->default(400);
            $table->integer('assetsqh')->default(400);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
