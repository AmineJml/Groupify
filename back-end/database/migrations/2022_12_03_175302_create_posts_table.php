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
/*============================Posts======================================================================*/
        Schema::create('posts', function (Blueprint $table) {
            $table->id("post_id");
            $table->integer("group_id");
            $table->integer("user_id");
            $table->string("post_title"); 
            $table->string("post_description"); 
            $table->string("post_URL"); 
            $table->integer("is_deleted")->default('0');  //how to decide the size of the string from laravel
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
