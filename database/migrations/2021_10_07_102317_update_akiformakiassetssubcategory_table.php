<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAkiformakiassetsubcategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('akiform_assets', function (Blueprint $table) {
            $table->string('subcategory')->nullable()->after('category');
            
        });

        Schema::create('akiform_subcategories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug')->nullable();
            $table->boolean('active')->default(1);
            $table->string('category')->nullable();
            $table->string('name')->nullable();
            $table->text('description', 255)->nullable();

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
