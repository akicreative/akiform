<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AkiformPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akiform_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('pagetitle');
            $table->text('metadescription')->nullable();
            $table->text('metakeywords')->nullable();
            $table->text('body')->nullable();
            $table->boolean('sitemap')->default(0);
            $table->decimal('sitemappriority', 2, 1);
            $table->string('url', 255);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akiform_pages');
    }
}
