<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkiinfolistTable extends Migration
{
    public function up()
    {
        Schema::create('akiform_infolists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('active')->default(0);
            $table->string('category', 50)->nullable();
            $table->string('infotype', 50)->nullable();
            $table->string('title', 255)->nullable();
            $table->boolean('html')->default(0);
            $table->string('description', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->boolean('newwindow')->default(0);
            $table->boolean('spaceafter')->default(0);
            $table->boolean('dividerafter')->default(0);
            $table->integer('imageabove_id')->default(0);
            $table->integer('imagebelow_id')->default(0);
            $table->integer('file_id')->default(0);
            $table->integer('orderby')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akiform_infolists');
    }
}
