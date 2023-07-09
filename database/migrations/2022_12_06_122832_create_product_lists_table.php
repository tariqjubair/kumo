<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('cata_id');
            $table->integer('subcata_id');
            $table->string('product_name');
            $table->string('slug');
            $table->integer('price');
            $table->integer('discount')->nullable();
            $table->integer('after_disc');
            $table->string('brand')->nullable();
            $table->string('preview')->nullable();
            $table->string('short_desc');
            $table->longText('long_desc')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_lists');
    }
};
