<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Wiki extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Wiki', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Author');
            $table->foreign('Author')->references('id')->on('users');
            $table->timestamps();
            $table->unsignedBigInteger('Views')->default(0);
        });

        Schema::create('Wiki_contributors', function (Blueprint $table) {
            $table->unsignedBigInteger('Article');
            $table->unsignedBigInteger('Contributor');

            $table->foreign('Article')->references('id')->on('Wiki');
            $table->foreign('Contributor')->references('id')->on('users');

            $table->primary(['Article', 'Contributor']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Wiki_contributors');
        Schema::dropIfExists('Wiki');
    }
}
