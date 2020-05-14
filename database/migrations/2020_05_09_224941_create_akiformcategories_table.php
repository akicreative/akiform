<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkiformcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akiform_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('slug')->unique();
            $table->string('cattype')->default('asset');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('hidden')->default(0);

            
        });

        DB::table('akiform_categories')->insert(array('slug' => 'assetgeneral', 'cattype' => 'asset', 'name' => 'General'));
        DB::table('akiform_categories')->insert(array('slug' => 'asseteditor', 'cattype' => 'asset', 'name' => 'Editor'));
        DB::table('akiform_categories')->insert(array('slug' => 'textblockgeneral', 'cattype' => 'textblock', 'name' => 'General'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akiform_categories');
    }
}
