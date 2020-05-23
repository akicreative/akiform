<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAkiformcategoriesAddassetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('akiform_categories', function (Blueprint $table) {
            $table->integer('assetw')->default(0);
            $table->integer('asseth')->default(0);
            $table->string('assettnresize', 20)->default('resize');
            $table->integer('assettnw')->default(0);
            $table->integer('assettnh')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('akiform_categories', function (Blueprint $table) {
            $table->dropColumn('assetw');
            $table->dropColumn('asseth');
            $table->dropColumn('assettnresize');
            $table->dropColumn('assettnw');
            $table->dropColumn('assettnh');
        });
    }
}
