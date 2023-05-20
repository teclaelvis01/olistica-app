<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOptionsRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_groups_options', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('option_groups_id')->nullable();
            $table->unsignedBigInteger('options_id')->nullable();

            $table->foreign('option_groups_id')->references('id')->on('option_groups')->onDelete('cascade');
            $table->foreign('options_id')->references('id')->on('options')->onDelete('cascade');

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
        Schema::dropIfExists('option_groups_options');
    }
}
