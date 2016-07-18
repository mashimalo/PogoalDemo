<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->unsignedInteger('privacy_rule_id');
            $table->foreign('privacy_rule_id')->references('id')->on('privacy_rules')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedInteger('group_type_id')->nullable();
            $table->foreign('group_type_id')->references('id')->on('group_types');
            $table->string('group_avatar_large')->nullable();
            $table->string('group_avatar_small')->nullable();
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
        Schema::drop('groups');
    }
}
