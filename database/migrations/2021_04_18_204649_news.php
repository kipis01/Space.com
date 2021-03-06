<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class News extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('News', function (Blueprint $table) {
            $table->id();
            $table->string('Title');
            $table->unsignedBigInteger('Author');
            $table->foreign('Author')->references('id')->on('users');
            $table->timestamps();
            $table->unsignedBigInteger('Views')->default(0);
        });

        Schema::create('News_Comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Author');
            $table->unsignedBigInteger('Article');
            $table->foreign('Author')->references('id')->on('users');
            $table->foreign('Article')->references('id')->on('News');
            $table->timestamps();
            $table->text('Message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('News_Comments');
        Schema::dropIfExists('News');
    }
}
