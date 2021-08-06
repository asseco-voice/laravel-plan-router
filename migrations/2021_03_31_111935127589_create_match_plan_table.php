<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_plan', function (Blueprint $table) {
            $table->id();

            if (config('asseco-plan-router.uuid')) {
                $table->foreignUuid('plan_id')->constrained()->cascadeOnDelete();
                $table->foreignUuid('match_id')->constrained()->cascadeOnDelete();
            } else {
                $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
                $table->foreignId('match_id')->constrained()->cascadeOnDelete();
            }

            $table->string('regex');
            $table->unique(['plan_id', 'match_id']);
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
        Schema::dropIfExists('match_plan');
    }
}
