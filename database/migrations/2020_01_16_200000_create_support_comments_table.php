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
        Schema::create('support_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('ticket_id');
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('ticket_id')->references('id')->on('support_tickets')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_comments');
    }
};
