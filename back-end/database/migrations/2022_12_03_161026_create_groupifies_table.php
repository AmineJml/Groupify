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
      //==================================My tables ================================================
/*============================users============================================================*/
        Schema::create('users', function (Blueprint $table) {
            $table->id("user_id");
            $table->string("username");
            $table->string("fname");
            $table->string("lname");
            $table->string("password");
        });
/*============================Groups============================================================*/
        Schema::create('groups', function (Blueprint $table) {
            $table->id("group_id");
            $table->integer("user_id"); // created by
            $table->string("group_name");
            $table->string("group_description");
        });
/*============================UsersJoinedGroups============================================================*/
        Schema::create('UsersJoinedGroups', function (Blueprint $table) {
            $table->integer("user_id");
            $table->integer("group_id");
            $table->integer("is_joined");
        });
/*============================likes========================================================================*/
        Schema::create('likes', function (Blueprint $table) {
            $table->integer("user_id");
            $table->integer("post_id");
            $table->integer("is_liked");
        });
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
        Schema::dropIfExists('groupifies');
    }
};
