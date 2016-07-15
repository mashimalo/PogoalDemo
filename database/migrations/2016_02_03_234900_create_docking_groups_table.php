<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDockingGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docking_groups',
            function (Blueprint $table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->unsignedInteger('group_1_id')->unsigned()->index();
                $table->foreign('group_1_id')->references('id')->on('groups')->onDelete('cascade');
                $table->unsignedInteger('group_2_id')->unsigned()->index();
                $table->foreign('group_2_id')->references('id')->on('groups')->onDelete('cascade');
                $table->string('docking_group_name', 50)->required();
                $table->unsignedInteger('privacy_rule_id');
                $table->foreign('privacy_rule_id')->references('id')->on('privacy_rules')->onDelete('restrict')->onUpdate('restrict');
                $table->boolean('accepted');
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
        Schema::drop('docking_groups');
    }
}
