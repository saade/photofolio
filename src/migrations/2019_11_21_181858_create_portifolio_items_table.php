<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortifolioItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portifolio_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('portifolio_id')->unsigned();
            $table->string('thumb_url')->nullable();
            $table->string('full_url')->nullable();
            $table->string('original_name')->nullable();
            $table->enum('grid_layout', ['portrait', 'landscape', 'square', 'big-square', 'random'])->default('random')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_cover')->default(false);
            $table->timestamps();

            $table->foreign('portifolio_id')->references('id')->on('portifolios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portifolio_items');
    }
}
