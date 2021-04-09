<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skillables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_group_id')->constrained()->onDelete('cascade');
            $table->morphs('skillable');
            $table->timestamps();
            
            $table->unique(['skill_group_id', 'skillable_type', 'skillable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skillables');
    }
}
