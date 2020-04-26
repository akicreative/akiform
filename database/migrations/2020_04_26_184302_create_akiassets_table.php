<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkiassetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        Schema::create('akiform_assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('code')->nullable();
            $table->string('category')->nullable();
            $table->bigInteger('referenceid')->default(0);
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('serverfilename', 255)->nullable();
            $table->string('filename', 255)->nullable();
            $table->string('mimetype')->nullable();
            $table->string('filesize')->nullable();
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
        Schema::dropIfExists('akiform_assets');
    }
}
