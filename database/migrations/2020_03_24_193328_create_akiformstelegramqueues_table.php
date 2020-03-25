<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkiformstelegramqueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akitelegramqueues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->dateTime('send_at');
            $table->bigInteger('ref_id');
            $table->string('ref_group')->default('general');
            $table->string('action')->default('send');
            $table->string('chat_id');
            $table->text('msg')->nullable();
            $table->string('parse_mode')->default('Markdown');
            $table->string('message_id');
            $table->text('error')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akitelegramqueues');
    }
}
