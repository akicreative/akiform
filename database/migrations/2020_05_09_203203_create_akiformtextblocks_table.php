<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkiformtextblocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akiform_textblocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('category')->default('textblockgeneral');
            $table->string('name')->nullable();
            $table->string('heading')->nullable();
            $table->text('textblock')->nullable();
            $table->string('format', 10)->default('html');
            $table->integer('orderby')->default(0);
            $table->integer('headerasset_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akiform_textblocks');
    }
}
