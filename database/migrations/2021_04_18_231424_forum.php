<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Forum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Forum', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Author');
            $table->foreign('Author')->references('id')->on('users');
            $table->string('Title');
            $table->timestamp('Date');
            $table->text('Message');
            $table->boolean('HasAttachments');
        });

        Schema::create('Forum_Comment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Post');
            $table->foreign('Post')->references('id')->on('Forum');
            $table->unsignedBigInteger('Author');
            $table->foreign('Author')->references('id')->on('users');

            $table->timestamp('Date');
            $table->text('Message');
            $table->boolean('HasAttachments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Forum_Comment');
        Schema::dropIfExists('Forum');
    }
}
