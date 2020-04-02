<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkinotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akiform_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->boolean('test_flg')->default(0);
            $table->string('notificationtype', 20)->default('email');
            $table->dateTime('send_at')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->bigInteger('ref_id')->default(0);
            $table->string('ref_group')->default('general');
            $table->text('body')->nullable();
            $table->string('email_fromemail')->nullable();
            $table->string('email_fromname')->nullable();
            $table->string('email_replyemail')->nullable();
            $table->string('email_replyname')->nullable();
            $table->string('email_toemail')->nullable();
            $table->string('email_toname')->nullable();
            $table->string('email_subject')->nullable();
            $table->string('email_textbody')->nullable();
            $table->string('email_tos')->nullable();
            $table->string('email_cc')->nullable();
            $table->string('email_bcc')->nullable();
            $table->string('telegram_action')->default('send');
            $table->string('telegram_chat_id');
            $table->string('telegram_parse_mode')->default('Markdown');
            $table->string('telegram_message_id');
            $table->boolean('error')->default(0);
            $table->text('errorinfo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akiform_notifications');
    }
}
