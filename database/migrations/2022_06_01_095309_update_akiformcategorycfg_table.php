<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAkiformcategorycfgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('akiform_categories', function (Blueprint $table) {
            $table->json('cfgs')->nullable();
            
        });


        Schema::table('akiform_textblocks', function (Blueprint $table) {
            $table->json('more')->nullable();
            
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
