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
/*============================comments======================================================================*/
        Schema::create('comments', function (Blueprint $table) {
            $table->id("comment_id");
            $table->integer("post_id");
            $table->integer("user_id");
            $table->string("comment"); //how to decide the size of the string from laravel
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
