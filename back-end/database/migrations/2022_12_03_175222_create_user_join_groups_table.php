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
/*============================UsersJoinedGroups============================================================*/
        Schema::create('UsersJoinedGroups', function (Blueprint $table) {
            $table->integer("user_id");
            $table->integer("group_id");
            $table->integer("is_joined");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_join_groups');
    }
};
